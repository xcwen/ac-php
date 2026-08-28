use std::env;
use std::fs;
use std::path::{Path, PathBuf};
use std::process::ExitCode;
use std::sync::atomic::{AtomicUsize, Ordering};

use ac_php_mago_tags::aggregate::aggregate;
use ac_php_mago_tags::cache::{Cache, signature};
use ac_php_mago_tags::config::AcPhpConfig;
use ac_php_mago_tags::discover::{SourceFile, discover};
use ac_php_mago_tags::emacs::write_tag_file;
use ac_php_mago_tags::model::{FileTags, IndexedFile};
use ac_php_mago_tags::scanner;
use anyhow::{Context, Result};
use clap::Parser;
use rayon::prelude::*;

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

    let sources = discover(&workspace, &config.filter)?;
    let cache = Cache::new(&output_dir, arguments.rebuild)?;
    let completed = AtomicUsize::new(0);
    let total = sources.len();
    let scanned = sources
        .par_iter()
        .map(|source| {
            let result = match load_or_scan(source, &workspace, &cache) {
                Err(error) if error.to_string().starts_with("PHPParser:") => {
                    println!("{error:#}");
                    empty_tags(source)
                }
                result => result?,
            };
            let done = completed.fetch_add(1, Ordering::Relaxed) + 1;
            let percent = done.saturating_mul(100).checked_div(total).unwrap_or(100);
            println!("{percent:02}% {}", source.path.display());
            Ok(result)
        })
        .collect::<Result<Vec<_>>>()?;

    let indexed = scanned
        .into_iter()
        .enumerate()
        .map(|(index, tags)| IndexedFile { index, tags })
        .collect::<Vec<_>>();
    let vendor_count = indexed.iter().take_while(|file| file.tags.vendor).count();
    let vendor_tags = aggregate(&indexed[..vendor_count]);
    let project_tags = aggregate(&indexed[vendor_count..]);

    let vendor_changed = write_tag_file(&output_dir.join("tags-vendor.el"), &vendor_tags)?;
    let project_changed = write_tag_file(&output_dir.join("tags.el"), &project_tags)?;
    println!(
        "100% generated {} project files and {} vendor files{}",
        indexed.len() - vendor_count,
        vendor_count,
        if vendor_changed || project_changed {
            ""
        } else {
            " (unchanged)"
        },
    );
    Ok(())
}

fn load_or_scan(
    source: &SourceFile,
    workspace: &Path,
    cache: &Cache,
) -> Result<ac_php_mago_tags::model::FileTags> {
    let source_signature = signature(&source.path)?;
    if let Some(tags) = cache.load(&source.path, &source_signature) {
        return Ok(tags);
    }
    let contents = fs::read(&source.path)
        .with_context(|| format!("failed to read {}", source.path.display()))?;
    let tags = scanner::scan(&source.path, workspace, contents.clone(), source.vendor)?;
    cache.store(&source.path, source_signature, &contents, tags.clone())?;
    Ok(tags)
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
