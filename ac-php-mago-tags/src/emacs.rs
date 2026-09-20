use std::fs;
use std::io::{BufWriter, Write};
use std::path::Path;
use std::time::SystemTime;

use anyhow::{Context, Result};

use crate::model::TagSet;

pub fn write_tag_file(path: &Path, tags: &TagSet) -> Result<bool> {
    let parent = path
        .parent()
        .context("tag output has no parent directory")?;
    fs::create_dir_all(parent)?;
    let mut temporary = tempfile::NamedTempFile::new_in(parent)?;
    {
        let mut writer = BufWriter::new(temporary.as_file_mut());
        write_tags(&mut writer, tags)?;
        writer.flush()?;
    }

    let generated = fs::read(temporary.path())?;
    if fs::read(path).ok().as_deref() == Some(generated.as_slice()) {
        fs::OpenOptions::new()
            .write(true)
            .open(path)
            .with_context(|| format!("failed to open {}", path.display()))?
            .set_times(fs::FileTimes::new().set_modified(SystemTime::now()))
            .with_context(|| format!("failed to refresh {}", path.display()))?;
        return Ok(false);
    }
    temporary
        .persist(path)
        .map_err(|error| error.error)
        .with_context(|| format!("failed to publish {}", path.display()))?;
    Ok(true)
}

pub fn write_tags(mut writer: impl Write, tags: &TagSet) -> Result<()> {
    writeln!(writer, "(setq  g-ac-php-tmp-tags  [")?;
    writeln!(writer, "(")?;
    for class in &tags.classes {
        writeln!(writer, "  (\"{}\".[", escape(&class.name))?;
        for member in &class.members {
            writeln!(
                writer,
                "    [\"{}\" \"{}\" \"{}\"  \"{}\"  \"{}\" \"{}\" \"{}\" \"{}\" \"{}\" ]",
                member.kind,
                escape(&member.name),
                escape(&member.args),
                escape(&member.location),
                escape(&member.return_type),
                escape(&member.class_name),
                escape(&member.access),
                if member.is_static { "1" } else { "" },
                escape(&member.typed_args),
            )?;
        }
        writeln!(writer, "  ])")?;
    }
    writeln!(writer, ")")?;
    writeln!(writer, "[")?;
    for global in &tags.globals {
        writeln!(
            writer,
            "  [\"{}\" \"{}\" \"{}\"  \"{}\"  \"{}\"  ]",
            global.kind,
            escape(&global.name),
            escape(&global.args),
            escape(&global.location),
            escape(&global.return_type),
        )?;
    }
    writeln!(writer, "]")?;
    writeln!(writer, "(")?;
    for (name, parents) in &tags.inherits {
        write!(writer, "  (\"{}\". [ ", escape(name))?;
        for parent in parents {
            write!(writer, "\"{}\" ", escape(parent))?;
        }
        writeln!(writer, "])")?;
    }
    writeln!(writer, ")")?;
    writeln!(writer, "[")?;
    for file in &tags.files {
        writeln!(writer, "  \"{}\"", escape(file))?;
    }
    writeln!(writer, "]")?;
    writeln!(writer, "])")?;
    Ok(())
}

pub fn escape(value: &str) -> String {
    let mut output = String::with_capacity(value.len());
    for character in value.chars() {
        match character {
            '\\' => output.push_str("\\\\"),
            '"' => output.push_str("\\\""),
            '\n' => output.push_str("\\n"),
            '\r' => output.push_str("\\r"),
            '\t' => output.push_str("\\t"),
            value if value.is_control() => output.push_str(&format!("\\u{:04x}", value as u32)),
            value => output.push(value),
        }
    }
    output
}

#[cfg(test)]
mod tests {
    use std::fs;
    use std::time::{Duration, SystemTime};

    use crate::model::{OutputClass, OutputMember, TagSet};

    use super::{escape, write_tag_file, write_tags};

    #[test]
    fn escapes_elisp_strings() {
        assert_eq!(escape("a\\b\"c\nd"), "a\\\\b\\\"c\\nd");
    }

    #[test]
    fn writes_typed_member_arguments_as_ninth_field() {
        let tags = TagSet {
            classes: vec![OutputClass {
                name: "\\Device".to_owned(),
                members: vec![OutputMember {
                    kind: "m".to_owned(),
                    name: "update(".to_owned(),
                    args: "$fields".to_owned(),
                    location: "0:1".to_owned(),
                    return_type: "int".to_owned(),
                    class_name: "\\Device".to_owned(),
                    access: "public".to_owned(),
                    is_static: false,
                    typed_args: "array{'name'?: string} $fields".to_owned(),
                }],
            }],
            ..TagSet::default()
        };
        let mut output = Vec::new();

        write_tags(&mut output, &tags).expect("write tags");
        let output = String::from_utf8(output).expect("UTF-8 tag file");

        assert!(output.contains("\"array{'name'?: string} $fields\" ]"));
    }

    #[test]
    fn refreshes_unchanged_tag_file_modification_time() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let path = directory.path().join("tags.el");
        let tags = TagSet::default();

        assert!(write_tag_file(&path, &tags).expect("initial tag write"));
        let contents = fs::read(&path).expect("tag contents");
        let old_modified = SystemTime::UNIX_EPOCH + Duration::from_secs(86_400);
        fs::OpenOptions::new()
            .write(true)
            .open(&path)
            .expect("open tag file")
            .set_times(fs::FileTimes::new().set_modified(old_modified))
            .expect("set old modification time");

        assert!(!write_tag_file(&path, &tags).expect("unchanged tag write"));
        assert_eq!(fs::read(&path).expect("refreshed tag contents"), contents);
        assert!(
            fs::metadata(&path)
                .expect("refreshed tag metadata")
                .modified()
                .expect("refreshed modification time")
                > old_modified
        );
    }
}
