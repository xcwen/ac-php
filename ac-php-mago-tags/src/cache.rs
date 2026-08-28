use std::fs;
use std::io::Write;
use std::path::{Path, PathBuf};
use std::time::UNIX_EPOCH;

use anyhow::{Context, Result};

use crate::model::{
    CACHE_SCHEMA_VERSION, CachedFile, FileTags, MAGO_VERSION, SourceSignature, VendorState,
};

pub struct Cache {
    root: PathBuf,
    rebuild: bool,
}

pub fn load_vendor_state(output_dir: &Path) -> Option<VendorState> {
    let bytes = fs::read(output_dir.join("mago-cache").join("vendor-state.postcard")).ok()?;
    let state: VendorState = postcard::from_bytes(&bytes).ok()?;
    (state.schema == CACHE_SCHEMA_VERSION).then_some(state)
}

pub fn store_vendor_state(output_dir: &Path, state: &VendorState) -> Result<()> {
    let cache_dir = output_dir.join("mago-cache");
    fs::create_dir_all(&cache_dir)?;
    let bytes = postcard::to_stdvec(state).context("failed to encode vendor state")?;
    let destination = cache_dir.join("vendor-state.postcard");
    let mut temporary = tempfile::NamedTempFile::new_in(&cache_dir)?;
    temporary.write_all(&bytes)?;
    temporary.flush()?;
    temporary
        .persist(&destination)
        .map_err(|error| error.error)
        .with_context(|| format!("failed to publish vendor state {}", destination.display()))?;
    Ok(())
}

impl Cache {
    pub fn new(output_dir: &Path, rebuild: bool) -> Result<Self> {
        let root = output_dir.join("mago-cache").join("files");
        fs::create_dir_all(&root)
            .with_context(|| format!("failed to create cache directory {}", root.display()))?;
        Ok(Self { root, rebuild })
    }

    pub fn load(&self, path: &Path) -> Option<CachedFile> {
        if self.rebuild {
            return None;
        }
        let bytes = fs::read(self.entry_path(path)).ok()?;
        let cached: CachedFile = postcard::from_bytes(&bytes).ok()?;
        if cached.schema != CACHE_SCHEMA_VERSION || cached.mago_version != MAGO_VERSION {
            return None;
        }
        Some(cached)
    }

    pub fn store(
        &self,
        path: &Path,
        signature: SourceSignature,
        source: &[u8],
        tags: FileTags,
    ) -> Result<()> {
        let cached = CachedFile {
            schema: CACHE_SCHEMA_VERSION,
            mago_version: MAGO_VERSION.to_owned(),
            signature,
            content_hash: *blake3::hash(source).as_bytes(),
            tags,
        };
        let bytes = postcard::to_stdvec(&cached).context("failed to encode cache entry")?;
        let destination = self.entry_path(path);
        let mut temporary = tempfile::NamedTempFile::new_in(&self.root)?;
        temporary.write_all(&bytes)?;
        temporary.flush()?;
        temporary
            .persist(&destination)
            .map_err(|error| error.error)
            .with_context(|| format!("failed to publish cache entry {}", destination.display()))?;
        Ok(())
    }

    fn entry_path(&self, path: &Path) -> PathBuf {
        let digest = blake3::hash(path.to_string_lossy().as_bytes()).to_hex();
        self.root.join(format!("{digest}.postcard"))
    }
}

pub fn signature(path: &Path) -> Result<SourceSignature> {
    let metadata =
        fs::metadata(path).with_context(|| format!("failed to stat {}", path.display()))?;
    let modified_ns = metadata
        .modified()
        .ok()
        .and_then(|time| time.duration_since(UNIX_EPOCH).ok())
        .map_or(0, |duration| duration.as_nanos());
    let created_ns = metadata
        .created()
        .ok()
        .and_then(|time| time.duration_since(UNIX_EPOCH).ok())
        .map_or(0, |duration| duration.as_nanos());

    #[cfg(unix)]
    use std::os::unix::fs::MetadataExt;

    Ok(SourceSignature {
        len: metadata.len(),
        modified_ns,
        created_ns,
        #[cfg(unix)]
        inode: metadata.ino(),
        #[cfg(not(unix))]
        inode: 0,
        #[cfg(unix)]
        device: metadata.dev(),
        #[cfg(not(unix))]
        device: 0,
    })
}
