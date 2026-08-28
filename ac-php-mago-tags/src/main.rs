use std::env;
use std::fs;
use std::path::{Path, PathBuf};
use std::process::ExitCode;
use std::sync::Mutex;
use std::sync::atomic::{AtomicUsize, Ordering};

use ac_php_mago_tags::aggregate::aggregate;
use ac_php_mago_tags::cache::{Cache, load_vendor_state, signature, store_vendor_state};
use ac_php_mago_tags::config::AcPhpConfig;
use ac_php_mago_tags::discover::{SourceFile, discover, discover_project};
use ac_php_mago_tags::emacs::write_tag_file;
use ac_php_mago_tags::model::{CACHE_SCHEMA_VERSION, FileTags, IndexedFile, VendorState};
use ac_php_mago_tags::scanner;
use anyhow::{Context, Result};
use clap::Parser;
use rayon::prelude::*;

#[derive(Debug, Clone, Copy)]
enum ScanState {
    MetadataCache,
    ContentCache,
    Parsed,
    Skipped,
}

impl ScanState {
    fn label(self) -> &'static str {
        match self {
            Self::MetadataCache => "cache",
            Self::ContentCache => "hash-cache",
            Self::Parsed => "scan",
            Self::Skipped => "skip",
        }
    }
}

struct ScanOutput {
    tags: FileTags,
    state: ScanState,
}

#[derive(Debug, Parser)]
#[command(version, about = "Generate ac-php Emacs tag files using Mago")]
struct Arguments {
    /// PHP project root. Defaults to the current directory.
    #[arg(long)]
    workspace: Option<PathBuf>,

    /// ac-php JSON configuration. Defaults to WORKSPACE/.ac-php-conf.json.
    #[arg(long = "config-file")]
    config_file: Option<PathBuf>,

    /// Directory in which tags.el and tags-vendor.el are written.
    #[arg(long)]
    output_dir: Option<PathBuf>,

    /// Ignore cached per-file tags and parse every source file.
    #[arg(long, default_value_t = false)]
    rebuild: bool,

    /// Number of parser workers. Defaults to Rayon's automatic selection.
    #[arg(long)]
    threads: Option<usize>,
}

fn main() -> ExitCode {
    match run(Arguments::parse()) {
        Ok(()) => ExitCode::SUCCESS,
        Err(error) => {
            eprintln!("{error:#}");
            ExitCode::FAILURE
        }
    }
}

fn run(arguments: Arguments) -> Result<()> {
    if let Some(threads) = arguments.threads {
        rayon::ThreadPoolBuilder::new()
            .num_threads(threads)
            .build_global()
            .context("failed to configure parser thread pool")?;
    }

    let workspace = arguments
        .workspace
        .unwrap_or(env::current_dir().context("failed to get current directory")?)
        .canonicalize()
        .context("failed to resolve workspace")?;
    let config_file = arguments
        .config_file
        .unwrap_or_else(|| workspace.join(".ac-php-conf.json"));
    let config = AcPhpConfig::load(&config_file)?;
    let output_dir =
        resolve_output_dir(&workspace, arguments.output_dir, config.tag_dir.as_deref())?;
    fs::create_dir_all(&output_dir)?;

    let composer_lock = workspace.join("composer.lock");
    let composer_lock_signature = if composer_lock.is_file() {
        Some(signature(&composer_lock)?)
    } else {
        None
    };
    let vendor_state = load_vendor_state(&output_dir);
    let rebuild_vendor = arguments.rebuild
        || !output_dir.join("tags-vendor.el").is_file()
        || vendor_state
            .as_ref()
            .is_none_or(|state| state.composer_lock_signature != composer_lock_signature);
    let sources = if rebuild_vendor {
        discover(&workspace, &config.filter)?
    } else {
        println!("50% vendor cache reused");
        discover_project(&workspace, &config.filter)?
    };
    let cache = Cache::new(&output_dir, arguments.rebuild)?;
    let completed = AtomicUsize::new(0);
    let metadata_cached = AtomicUsize::new(0);
    let content_cached = AtomicUsize::new(0);
    let parsed = AtomicUsize::new(0);
    let skipped = AtomicUsize::new(0);
    let reported_percent = Mutex::new(0_usize);
    let total = sources.len();
    let start_percent = if rebuild_vendor { 0 } else { 50 };
    let percent_range = 100 - start_percent;
    let outputs = sources
        .par_iter()
        .map(|source| {
            let output = match load_or_scan(source, &workspace, &cache) {
                Err(error) if error.to_string().starts_with("PHPParser:") => {
                    println!("{error:#}");
                    ScanOutput {
                        tags: empty_tags(source),
                        state: ScanState::Skipped,
                    }
                }
                result => result?,
            };
            match output.state {
                ScanState::MetadataCache => {
                    metadata_cached.fetch_add(1, Ordering::Relaxed);
                }
                ScanState::ContentCache => {
                    content_cached.fetch_add(1, Ordering::Relaxed);
                }
                ScanState::Parsed => {
                    parsed.fetch_add(1, Ordering::Relaxed);
                }
                ScanState::Skipped => {
                    skipped.fetch_add(1, Ordering::Relaxed);
                }
            }
            let done = completed.fetch_add(1, Ordering::Relaxed) + 1;
            let percent = start_percent
                + done
                    .saturating_mul(percent_range)
                    .checked_div(total)
                    .unwrap_or(percent_range);
            let mut last_percent = reported_percent.lock().expect("progress mutex poisoned");
            if !matches!(output.state, ScanState::MetadataCache) && percent > *last_percent {
                println!(
                    "{percent:02}% {} {}",
                    output.state.label(),
                    source.path.display()
                );
                *last_percent = percent;
            }
            Ok(output)
        })
        .collect::<Result<Vec<_>>>()?;

    let vendor_offset = if rebuild_vendor {
        0
    } else {
        vendor_state.as_ref().map_or(0, |state| state.file_count)
    };
    let indexed = outputs
        .into_iter()
        .enumerate()
        .map(|(index, output)| IndexedFile {
            index: vendor_offset + index,
            tags: output.tags,
        })
        .collect::<Vec<_>>();
    let vendor_count = if rebuild_vendor {
        indexed.iter().take_while(|file| file.tags.vendor).count()
    } else {
        vendor_offset
    };
    let project_start = if rebuild_vendor { vendor_count } else { 0 };
    let project_tags = aggregate(&indexed[project_start..]);

    let vendor_changed = if rebuild_vendor {
        let vendor_tags = aggregate(&indexed[..vendor_count]);
        let changed = write_tag_file(&output_dir.join("tags-vendor.el"), &vendor_tags)?;
        store_vendor_state(
            &output_dir,
            &VendorState {
                schema: CACHE_SCHEMA_VERSION,
                composer_lock_signature,
                file_count: vendor_count,
            },
        )?;
        changed
    } else {
        false
    };
    let project_changed = write_tag_file(&output_dir.join("tags.el"), &project_tags)?;
    let project_count = indexed.len() - project_start;
    println!(
        "100% generated {} project files and {} vendor files: parsed={}, cached={}, hash-cached={}, skipped={}{}",
        project_count,
        vendor_count,
        parsed.load(Ordering::Relaxed),
        metadata_cached.load(Ordering::Relaxed),
        content_cached.load(Ordering::Relaxed),
        skipped.load(Ordering::Relaxed),
        if vendor_changed || project_changed {
            ""
        } else {
            " (unchanged)"
        },
    );
    Ok(())
}

fn load_or_scan(source: &SourceFile, workspace: &Path, cache: &Cache) -> Result<ScanOutput> {
    let source_signature = signature(&source.path)?;
    let cached = cache.load(&source.path);
    if let Some(cached) = cached.as_ref()
        && cached.signature == source_signature
    {
        return Ok(ScanOutput {
            tags: cached.tags.clone(),
            state: ScanState::MetadataCache,
        });
    }
    let contents = fs::read(&source.path)
        .with_context(|| format!("failed to read {}", source.path.display()))?;
    if let Some(cached) = cached
        && cached.content_hash == *blake3::hash(&contents).as_bytes()
    {
        cache.store(
            &source.path,
            source_signature,
            &contents,
            cached.tags.clone(),
        )?;
        return Ok(ScanOutput {
            tags: cached.tags,
            state: ScanState::ContentCache,
        });
    }
    let tags = scanner::scan(&source.path, workspace, contents.clone(), source.vendor)?;
    cache.store(&source.path, source_signature, &contents, tags.clone())?;
    Ok(ScanOutput {
        tags,
        state: ScanState::Parsed,
    })
}

fn empty_tags(source: &SourceFile) -> FileTags {
    FileTags {
        path: source.path.to_string_lossy().into_owned(),
        vendor: source.vendor,
        classes: Vec::new(),
        functions: Vec::new(),
        constants: Vec::new(),
    }
}

fn resolve_output_dir(
    workspace: &Path,
    cli: Option<PathBuf>,
    configured: Option<&Path>,
) -> Result<PathBuf> {
    let output = cli
        .or_else(|| configured.map(Path::to_owned))
        .unwrap_or_else(|| workspace.join(".ac-php-tags"));
    let output = if output.is_absolute() {
        output
    } else {
        workspace.join(output)
    };
    Ok(output)
}
