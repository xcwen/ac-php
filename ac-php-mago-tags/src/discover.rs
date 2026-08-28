use std::collections::BTreeSet;
use std::fs;
use std::path::{Component, Path, PathBuf};

use anyhow::{Context, Result};
use ignore::gitignore::{Gitignore, GitignoreBuilder};
use walkdir::{DirEntry, WalkDir};

use crate::config::FilterConfig;

#[derive(Debug, Clone)]
pub struct SourceFile {
    pub path: PathBuf,
    pub vendor: bool,
}

pub fn discover(workspace: &Path, config: &FilterConfig) -> Result<Vec<SourceFile>> {
    discover_internal(workspace, config, true)
}

pub fn discover_project(workspace: &Path, config: &FilterConfig) -> Result<Vec<SourceFile>> {
    discover_internal(workspace, config, false)
}

fn discover_internal(
    workspace: &Path,
    config: &FilterConfig,
    include_vendor: bool,
) -> Result<Vec<SourceFile>> {
    let matcher = build_ignore_matcher(workspace, &config.ignore_rules)?;
    let extensions: BTreeSet<String> = config
        .extensions
        .iter()
        .map(|extension| extension.trim_start_matches('.').to_ascii_lowercase())
        .collect();
    let mut files = BTreeSet::new();

    for configured_path in &config.recursive_paths {
        let root = resolve(workspace, configured_path)?;
        if root.is_file() {
            add_if_php(&mut files, &root, &extensions, workspace, &matcher);
            continue;
        }
        for entry in WalkDir::new(&root)
            .follow_links(false)
            .into_iter()
            .filter_entry(|entry| visible_entry(entry, include_vendor))
        {
            let entry = entry.with_context(|| format!("failed to walk {}", root.display()))?;
            if entry.file_type().is_file() {
                add_if_php(&mut files, entry.path(), &extensions, workspace, &matcher);
            }
        }
    }

    for configured_path in &config.flat_paths {
        let root = resolve(workspace, configured_path)?;
        if root.is_file() {
            add_if_php(&mut files, &root, &extensions, workspace, &matcher);
            continue;
        }
        for entry in
            fs::read_dir(&root).with_context(|| format!("failed to read {}", root.display()))?
        {
            let path = entry?.path();
            if path.is_file() && (include_vendor || !is_vendor(&path)) {
                add_if_php(&mut files, &path, &extensions, workspace, &matcher);
            }
        }
    }

    let mut result: Vec<_> = files
        .into_iter()
        .filter(|path| include_vendor || !is_vendor(path))
        .map(|path| SourceFile {
            vendor: is_vendor(&path),
            path,
        })
        .collect();
    result.sort_by(|left, right| (!left.vendor, &left.path).cmp(&(!right.vendor, &right.path)));
    Ok(result)
}

fn resolve(workspace: &Path, path: &Path) -> Result<PathBuf> {
    let path = if path.is_absolute() {
        path.to_owned()
    } else {
        workspace.join(path)
    };
    path.canonicalize()
        .with_context(|| format!("source path does not exist: {}", path.display()))
}

fn visible_entry(entry: &DirEntry, include_vendor: bool) -> bool {
    entry.depth() == 0
        || (!entry.file_name().to_string_lossy().starts_with('.')
            && (include_vendor || entry.file_name() != "vendor"))
}

fn add_if_php(
    files: &mut BTreeSet<PathBuf>,
    path: &Path,
    extensions: &BTreeSet<String>,
    workspace: &Path,
    matcher: &Gitignore,
) {
    let Some(extension) = path.extension().and_then(|value| value.to_str()) else {
        return;
    };
    if !extensions.contains(&extension.to_ascii_lowercase()) {
        return;
    }
    let relative = path.strip_prefix(workspace).unwrap_or(path);
    if matcher
        .matched_path_or_any_parents(relative, false)
        .is_ignore()
    {
        return;
    }
    files.insert(path.to_owned());
}

fn build_ignore_matcher(workspace: &Path, rules: &[String]) -> Result<Gitignore> {
    let mut builder = GitignoreBuilder::new(workspace);
    for rule in rules {
        if rule.trim().is_empty() || rule.trim_start().starts_with('#') {
            continue;
        }
        builder
            .add_line(None, rule)
            .with_context(|| format!("invalid ignore rule: {rule}"))?;
    }
    builder.build().context("failed to build ignore rules")
}

fn is_vendor(path: &Path) -> bool {
    path.components()
        .any(|component| matches!(component, Component::Normal(name) if name == "vendor"))
}

#[cfg(test)]
mod tests {
    use std::fs;
    use std::path::Path;

    use crate::config::FilterConfig;

    use super::{discover_project, is_vendor};

    #[test]
    fn vendor_is_a_path_component() {
        assert!(is_vendor(Path::new("/tmp/app/vendor/pkg/A.php")));
        assert!(!is_vendor(Path::new("/tmp/app/my-vendor/A.php")));
    }

    #[test]
    fn project_discovery_skips_vendor_tree() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let vendor = directory.path().join("vendor/package");
        fs::create_dir_all(&vendor).expect("create vendor fixture");
        fs::write(directory.path().join("App.php"), "<?php class App {}")
            .expect("write project fixture");
        fs::write(vendor.join("Dependency.php"), "<?php class Dependency {}")
            .expect("write vendor fixture");

        let files = discover_project(directory.path(), &FilterConfig::default())
            .expect("discover project files");

        assert_eq!(files.len(), 1);
        assert!(files[0].path.ends_with("App.php"));
        assert!(!files[0].vendor);
    }
}
