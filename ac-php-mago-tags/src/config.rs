use std::fs;
use std::path::{Path, PathBuf};

use anyhow::{Context, Result};
use serde::Deserialize;

#[derive(Debug, Clone, Deserialize)]
pub struct AcPhpConfig {
    #[serde(rename = "tag-dir")]
    pub tag_dir: Option<PathBuf>,
    #[serde(default)]
    pub filter: FilterConfig,
}

#[derive(Debug, Clone, Deserialize)]
pub struct FilterConfig {
    #[serde(rename = "php-file-ext-list", default = "default_extensions")]
    pub extensions: Vec<String>,
    #[serde(rename = "php-path-list", default = "default_paths")]
    pub recursive_paths: Vec<PathBuf>,
    #[serde(rename = "php-path-list-without-subdir", default)]
    pub flat_paths: Vec<PathBuf>,
    #[serde(rename = "ignore-ruleset", default)]
    pub ignore_rules: Vec<String>,
}

impl Default for FilterConfig {
    fn default() -> Self {
        Self {
            extensions: default_extensions(),
            recursive_paths: default_paths(),
            flat_paths: Vec::new(),
            ignore_rules: Vec::new(),
        }
    }
}

fn default_extensions() -> Vec<String> {
    vec!["php".to_owned()]
}

fn default_paths() -> Vec<PathBuf> {
    vec![PathBuf::from(".")]
}

impl AcPhpConfig {
    pub fn load(path: &Path) -> Result<Self> {
        let contents = fs::read_to_string(path)
            .with_context(|| format!("failed to read configuration {}", path.display()))?;
        if contents.trim().is_empty() {
            return Ok(Self {
                tag_dir: None,
                filter: FilterConfig::default(),
            });
        }
        serde_json::from_str(&contents)
            .with_context(|| format!("failed to parse configuration {}", path.display()))
    }
}
