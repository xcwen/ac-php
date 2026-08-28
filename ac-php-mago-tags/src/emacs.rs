use std::fs;
use std::io::{BufWriter, Write};
use std::path::Path;

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
                "    [\"{}\" \"{}\" \"{}\"  \"{}\"  \"{}\" \"{}\" \"{}\" \"{}\" ]",
                member.kind,
                escape(&member.name),
                escape(&member.args),
                escape(&member.location),
                escape(&member.return_type),
                escape(&member.class_name),
                escape(&member.access),
                if member.is_static { "1" } else { "" },
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
    use super::escape;

    #[test]
    fn escapes_elisp_strings() {
        assert_eq!(escape("a\\b\"c\nd"), "a\\\\b\\\"c\\nd");
    }
}
