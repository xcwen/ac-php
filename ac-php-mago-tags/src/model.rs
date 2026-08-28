use serde::{Deserialize, Serialize};

pub const CACHE_SCHEMA_VERSION: u32 = 1;
pub const MAGO_VERSION: &str = "1.47.4";

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct FileTags {
    pub path: String,
    pub vendor: bool,
    pub classes: Vec<ClassTag>,
    pub functions: Vec<FunctionTag>,
    pub constants: Vec<ConstantTag>,
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct ClassTag {
    pub kind: ClassKind,
    pub name: String,
    pub line: u32,
    pub inherits: Vec<String>,
    pub members: Vec<MemberTag>,
}

#[derive(Debug, Clone, Copy, Serialize, Deserialize, PartialEq, Eq)]
pub enum ClassKind {
    Class,
    Interface,
    Trait,
    Enum,
}

impl ClassKind {
    pub fn legacy_kind(self) -> &'static str {
        match self {
            Self::Class | Self::Enum => "c",
            Self::Interface => "i",
            Self::Trait => "t",
        }
    }
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct MemberTag {
    pub kind: MemberKind,
    pub name: String,
    pub args: String,
    pub line: u32,
    pub return_type: String,
    pub access: String,
    pub is_static: bool,
}

#[derive(Debug, Clone, Copy, Serialize, Deserialize, PartialEq, Eq)]
pub enum MemberKind {
    Method,
    Property,
    Constant,
}

impl MemberKind {
    pub fn legacy_kind(self) -> &'static str {
        match self {
            Self::Method => "m",
            Self::Property => "p",
            Self::Constant => "d",
        }
    }
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct FunctionTag {
    pub name: String,
    pub args: String,
    pub line: u32,
    pub return_type: String,
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct ConstantTag {
    pub name: String,
    pub line: u32,
    pub return_type: String,
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct SourceSignature {
    pub len: u64,
    pub modified_ns: u128,
    pub created_ns: u128,
    pub inode: u64,
    pub device: u64,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct CachedFile {
    pub schema: u32,
    pub mago_version: String,
    pub signature: SourceSignature,
    pub content_hash: [u8; 32],
    pub tags: FileTags,
}

#[derive(Debug, Clone, Serialize, Deserialize, PartialEq, Eq)]
pub struct VendorState {
    pub schema: u32,
    pub composer_lock_signature: Option<SourceSignature>,
    pub file_count: usize,
}

#[derive(Debug, Clone, PartialEq, Eq)]
pub struct IndexedFile {
    pub index: usize,
    pub tags: FileTags,
}

#[derive(Debug, Clone, Default, PartialEq, Eq)]
pub struct TagSet {
    pub classes: Vec<OutputClass>,
    pub globals: Vec<GlobalTag>,
    pub inherits: Vec<(String, Vec<String>)>,
    pub files: Vec<String>,
}

#[derive(Debug, Clone, PartialEq, Eq)]
pub struct OutputClass {
    pub name: String,
    pub members: Vec<OutputMember>,
}

#[derive(Debug, Clone, PartialEq, Eq)]
pub struct OutputMember {
    pub kind: String,
    pub name: String,
    pub args: String,
    pub location: String,
    pub return_type: String,
    pub class_name: String,
    pub access: String,
    pub is_static: bool,
}

#[derive(Debug, Clone, PartialEq, Eq)]
pub struct GlobalTag {
    pub kind: String,
    pub name: String,
    pub args: String,
    pub location: String,
    pub return_type: String,
}

pub fn fqcn(name: impl AsRef<str>) -> String {
    let name = name.as_ref();
    if name.starts_with('\\') {
        name.to_owned()
    } else {
        format!("\\{name}")
    }
}
