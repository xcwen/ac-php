use std::borrow::Cow;
use std::path::Path;

use anyhow::{Context, Result, bail};
use mago_allocator::LocalArena;
use mago_codex::metadata::function_like::{FunctionLikeKind, FunctionLikeMetadata};
use mago_codex::metadata::property::PropertyMetadata;
use mago_codex::scanner::scan_program;
use mago_codex::symbol::SymbolKind;
use mago_codex::ttype::TType;
use mago_codex::visibility::Visibility;
use mago_database::file::{File, FileType};
use mago_names::resolver::NameResolver;
use mago_php_version::PHPVersion;
use mago_phpdoc_syntax::PHPDocParser;
use mago_phpdoc_syntax::cst::TagValue;
use mago_span::Span;
use mago_syntax::comments::docblock::get_docblock_before_position;
use mago_syntax::cst::Program;
use mago_syntax::parser::parse_file;

use crate::model::{
    ClassKind, ClassTag, ConstantTag, FileTags, FunctionTag, MemberKind, MemberTag, fqcn,
};

pub fn scan(path: &Path, workspace: &Path, source: Vec<u8>, vendor: bool) -> Result<FileTags> {
    let file_type = if vendor {
        FileType::Vendored
    } else {
        FileType::Host
    };
    let logical_name = path
        .strip_prefix(workspace)
        .unwrap_or(path)
        .to_string_lossy()
        .into_owned()
        .into_bytes();
    let file = File::new(
        Cow::Owned(logical_name),
        file_type,
        Some(path.to_owned()),
        Cow::Owned(source),
    );
    let arena = LocalArena::new();
    let program = parse_file(&arena, &file);
    if program.has_errors() {
        let details = program
            .errors
            .first()
            .map_or_else(|| "unknown parse error".to_owned(), ToString::to_string);
        bail!("PHPParser: {details} - {}", path.display());
    }

    let resolved_names = NameResolver::new(&arena).resolve(program);
    let metadata = scan_program(&arena, &file, program, &resolved_names, PHPVersion::LATEST);
    let source = file.contents.as_ref();

    let mut classes = Vec::new();
    for class in metadata.class_likes.values() {
        let class_name = fqcn(word_string(class.original_name.as_bytes()));
        if class_name.starts_with("\\{anonymous-class:") {
            continue;
        }
        let kind = match class.kind {
            SymbolKind::Class => ClassKind::Class,
            SymbolKind::Interface => ClassKind::Interface,
            SymbolKind::Trait => ClassKind::Trait,
            SymbolKind::Enum => ClassKind::Enum,
        };
        let mut inherits = Vec::new();
        if let Some(parent) = class.direct_parent_class {
            inherits.push(fqcn(word_string(parent.as_bytes())));
        }
        inherits.extend(
            class
                .direct_parent_interfaces
                .iter()
                .filter(|name| !is_synthetic_enum_parent(name.as_bytes()))
                .map(|name| fqcn(word_string(name.as_bytes()))),
        );
        inherits.extend(
            class
                .used_traits
                .iter()
                .map(|name| fqcn(word_string(name.as_bytes()))),
        );
        for mixin in &class.mixins {
            let name = type_name(mixin);
            if !name.is_empty() {
                inherits.push(name);
            }
        }
        if kind == ClassKind::Enum {
            inherits.push("enum_".to_owned());
        }
        inherits.sort();
        inherits.dedup();

        let mut members = Vec::new();
        for method_name in &class.methods {
            let Some(method) = metadata.function_likes.get(&(class.name, *method_name)) else {
                continue;
            };
            if method.name_span.is_none() && !method.flags.is_magic_method() {
                continue;
            }
            members.push(method_tag(method, &file, source));
        }
        for property in class.properties.values() {
            if property.name_span.is_none() && property.span.is_none() {
                continue;
            }
            members.push(property_tag(property, &file, None));
        }
        for property in class.magic_properties.values() {
            if !class.properties.contains_key(&property.name.0) {
                let property_line =
                    magic_property_line(&arena, &file, program, class.span, property);
                members.push(property_tag(property, &file, property_line));
            }
        }
        for constant in class.constants.values() {
            members.push(MemberTag {
                kind: MemberKind::Constant,
                name: word_string(constant.name.as_bytes()),
                args: String::new(),
                line: line(&file, constant.span),
                return_type: constant
                    .type_metadata
                    .as_ref()
                    .map_or_else(|| "void".to_owned(), type_name),
                access: visibility(constant.visibility),
                is_static: false,
                typed_args: String::new(),
            });
        }
        for case in class.enum_cases.values() {
            members.push(MemberTag {
                kind: MemberKind::Constant,
                name: word_string(case.name.as_bytes()),
                args: String::new(),
                line: line(&file, case.name_span),
                return_type: "void".to_owned(),
                access: "public".to_owned(),
                is_static: false,
                typed_args: String::new(),
            });
        }
        members.sort_by(|left, right| (left.line, &left.name).cmp(&(right.line, &right.name)));

        classes.push(ClassTag {
            kind,
            name: class_name,
            line: line(&file, class.name_span.unwrap_or(class.span)),
            inherits,
            members,
        });
    }
    classes.sort_by(|left, right| left.name.cmp(&right.name));

    let mut functions = Vec::new();
    for function in metadata.function_likes.values() {
        if function.kind != FunctionLikeKind::Function {
            continue;
        }
        let mut name = word_string(function.original_name.as_bytes());
        if !name.contains('\\') {
            name = name
                .strip_prefix("PS_UNRESERVE_PREFIX_")
                .unwrap_or(&name)
                .to_owned();
        }
        functions.push(FunctionTag {
            name: fqcn(name),
            args: arguments(function, source),
            line: line(&file, function.name_span.unwrap_or(function.span)),
            return_type: return_type(function),
        });
    }
    functions.sort_by(|left, right| (&left.name, left.line).cmp(&(&right.name, right.line)));

    let mut constants = metadata
        .constants
        .values()
        .map(|constant| ConstantTag {
            name: fqcn(word_string(constant.name.as_bytes())),
            line: line(&file, constant.span),
            return_type: constant
                .type_metadata
                .as_ref()
                .map_or_else(|| "void".to_owned(), type_name),
        })
        .collect::<Vec<_>>();
    constants.sort_by(|left, right| (&left.name, left.line).cmp(&(&right.name, right.line)));

    Ok(FileTags {
        path: path
            .canonicalize()
            .with_context(|| format!("failed to canonicalize {}", path.display()))?
            .to_string_lossy()
            .into_owned(),
        vendor,
        classes,
        functions,
        constants,
    })
}

fn method_tag(method: &FunctionLikeMetadata, file: &File, source: &[u8]) -> MemberTag {
    let method_metadata = method.method_metadata.as_ref();
    MemberTag {
        kind: MemberKind::Method,
        name: word_string(method.original_name.as_bytes()),
        args: arguments(method, source),
        line: line(file, method.name_span.unwrap_or(method.span)),
        return_type: return_type(method),
        access: method_metadata
            .map_or_else(|| "public".to_owned(), |value| visibility(value.visibility)),
        is_static: method_metadata.is_some_and(|value| value.is_static),
        typed_args: typed_arguments(method),
    }
}

fn property_tag(property: &PropertyMetadata, file: &File, source_line: Option<u32>) -> MemberTag {
    MemberTag {
        kind: MemberKind::Property,
        name: word_string(property.name.0.as_bytes())
            .trim_start_matches('$')
            .to_owned(),
        args: String::new(),
        line: source_line
            .or_else(|| {
                property
                    .name_span
                    .or(property.span)
                    .map(|span| line(file, span))
            })
            .unwrap_or(1),
        return_type: property
            .type_metadata
            .as_ref()
            .map_or_else(String::new, type_name),
        access: visibility(property.read_visibility),
        is_static: property.flags.is_static(),
        typed_args: String::new(),
    }
}

fn magic_property_line<'arena>(
    arena: &'arena LocalArena,
    file: &File,
    program: &'arena Program<'arena>,
    class_span: Span,
    property: &PropertyMetadata,
) -> Option<u32> {
    let docblock =
        get_docblock_before_position(program.trivia.as_slice(), class_span.start.offset)?;
    let document = PHPDocParser::parse_with_span(arena, docblock.value, docblock.span);
    let property_name = property.name.0.as_bytes();

    document.tags().find_map(|tag| {
        let value = match &tag.value {
            TagValue::Property(value)
            | TagValue::PropertyRead(value)
            | TagValue::PropertyWrite(value) => value,
            _ => return None,
        };

        (value.variable.value == property_name).then(|| line(file, value.variable.span))
    })
}

fn typed_arguments(function: &FunctionLikeMetadata) -> String {
    function
        .parameters
        .iter()
        .map(|parameter| {
            let name = word_string(parameter.name.0.as_bytes());
            parameter
                .type_metadata
                .as_ref()
                .map_or(name.clone(), |metadata| {
                    format!(
                        "{} {name}",
                        word_string(metadata.type_union.get_id().as_bytes())
                    )
                })
        })
        .collect::<Vec<_>>()
        .join(", ")
}

fn arguments(function: &FunctionLikeMetadata, source: &[u8]) -> String {
    function
        .parameters
        .iter()
        .map(|parameter| {
            let name = word_string(parameter.name.0.as_bytes());
            let start = parameter.name_span.end.offset as usize;
            let end = parameter.span.end.offset as usize;
            let raw = source
                .get(start..end)
                .and_then(|bytes| std::str::from_utf8(bytes).ok())
                .unwrap_or("");
            let suffix = raw.find('=').map(|offset| raw[offset + 1..].trim());
            match suffix {
                Some(default) if !default.is_empty() => format!("{name}={default}"),
                _ => name,
            }
        })
        .collect::<Vec<_>>()
        .join(", ")
}

fn return_type(function: &FunctionLikeMetadata) -> String {
    function
        .return_type_metadata
        .as_ref()
        .map_or_else(String::new, type_name)
}

fn type_name(metadata: &mago_codex::metadata::ttype::TypeMetadata) -> String {
    legacy_type(&word_string(metadata.type_union.get_id().as_bytes()))
}

fn legacy_type(name: &str) -> String {
    let alternatives = split_top_level(name, '|');
    let selected = alternatives
        .iter()
        .find(|value| object_name(value).is_some())
        .or_else(|| alternatives.iter().find(|value| value.as_str() != "null"))
        .map_or(name, String::as_str);

    if let Some(object) = object_name(selected) {
        return fqcn(object);
    }
    if selected.starts_with("array<") || selected.starts_with("list<") {
        return "array".to_owned();
    }
    if selected.starts_with("string(") {
        return "string".to_owned();
    }
    if selected.starts_with("int(") {
        return "int".to_owned();
    }
    if is_builtin_type(selected) || selected.starts_with('\\') {
        selected.to_owned()
    } else {
        fqcn(selected)
    }
}

fn object_name(value: &str) -> Option<&str> {
    for prefix in ["unknown-ref(", "enum("] {
        if let Some(inner) = value
            .strip_prefix(prefix)
            .and_then(|value| value.strip_suffix(')'))
        {
            return Some(inner);
        }
    }
    None
}

fn split_top_level(value: &str, delimiter: char) -> Vec<String> {
    let mut depth = 0_u32;
    let mut start = 0;
    let mut result = Vec::new();
    for (offset, character) in value.char_indices() {
        match character {
            '(' | '<' | '{' | '[' => depth += 1,
            ')' | '>' | '}' | ']' => depth = depth.saturating_sub(1),
            current if current == delimiter && depth == 0 => {
                result.push(value_slice(value, start, offset));
                start = offset + current.len_utf8();
            }
            _ => {}
        }
    }
    result.push(value_slice(value, start, value.len()));
    result
}

fn value_slice(value: &str, start: usize, end: usize) -> String {
    value[start..end].trim().to_owned()
}

fn is_builtin_type(name: &str) -> bool {
    name.contains('|')
        || name.contains('&')
        || name.contains('<')
        || matches!(
            name,
            "" | "array"
                | "bool"
                | "callable"
                | "false"
                | "float"
                | "int"
                | "iterable"
                | "mixed"
                | "never"
                | "null"
                | "object"
                | "resource"
                | "self"
                | "static"
                | "string"
                | "true"
                | "void"
        )
}

fn is_synthetic_enum_parent(name: &[u8]) -> bool {
    matches!(
        name,
        b"unitenum"
            | b"backedenum"
            | b"__internal_do_not_use__intbackedenum"
            | b"__internal_do_not_use__stringbackedenum"
    )
}

fn visibility(value: Visibility) -> String {
    String::from_utf8_lossy(value.as_bytes()).into_owned()
}

fn line(file: &File, span: Span) -> u32 {
    file.line_number(span.start.offset) + 1
}

fn word_string(bytes: &[u8]) -> String {
    String::from_utf8_lossy(bytes).into_owned()
}

#[cfg(test)]
mod tests {
    use std::fs;

    use super::{legacy_type, scan};

    #[test]
    fn simplifies_mago_types_for_ac_php() {
        assert_eq!(
            legacy_type("null|unknown-ref(Test\\Result)"),
            "\\Test\\Result"
        );
        assert_eq!(legacy_type("list<string>"), "array");
        assert_eq!(legacy_type("string('ok')"), "string");
        assert_eq!(legacy_type("int|null"), "int");
    }

    #[test]
    fn keeps_mago_enum_methods() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let path = directory.path().join("Status.php");
        let source = b"<?php enum Status: string { case Ready = 'ready'; }".to_vec();
        fs::write(&path, &source).expect("write PHP fixture");

        let tags = scan(&path, directory.path(), source, false).expect("scan enum fixture");
        let method_names = tags.classes[0]
            .members
            .iter()
            .map(|member| member.name.as_str())
            .collect::<Vec<_>>();

        assert!(method_names.contains(&"cases"));
        assert!(method_names.contains(&"from"));
        assert!(method_names.contains(&"tryFrom"));
    }

    #[test]
    fn keeps_magic_method_array_shape_parameter_types() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let path = directory.path().join("Device.php");
        let source = br#"<?php
/**
 * @method int field_update_list(
 *   int|array{voice_device_id: int}|array{sn: string} $voice_device_id,
 *   array{tenant_id?: int, net_type?: int|null, ...<int, string>} $set_field_arr
 * )
 */
class Device {}
"#
        .to_vec();
        fs::write(&path, &source).expect("write PHP fixture");

        let tags = scan(&path, directory.path(), source, false).expect("scan PHPDoc fixture");
        let method = tags.classes[0]
            .members
            .iter()
            .find(|member| member.name == "field_update_list")
            .expect("magic method tag");

        assert_eq!(method.args, "$voice_device_id, $set_field_arr");
        assert!(
            method.typed_args.contains("'voice_device_id': int"),
            "{}",
            method.typed_args
        );
        assert!(method.typed_args.contains("'sn': string"));
        assert!(method.typed_args.contains("'tenant_id'?: int"));
        assert!(method.typed_args.contains("...<int, string>"));
    }

    #[test]
    fn adds_phpdoc_mixins_to_class_inheritance() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let path = directory.path().join("CmdBase.php");
        let source = br#"<?php
namespace Gen\Commands;

/**
 * @mixin \Gen\Controllers\ControllerEx
 */
class CmdBase extends Command {}
"#
        .to_vec();
        fs::write(&path, &source).expect("write PHP fixture");

        let tags = scan(&path, directory.path(), source, false).expect("scan PHPDoc fixture");
        let class = tags
            .classes
            .iter()
            .find(|class| class.name == "\\Gen\\Commands\\CmdBase")
            .expect("CmdBase class tag");

        assert!(
            class
                .inherits
                .contains(&"\\Gen\\Controllers\\ControllerEx".to_owned()),
            "{:?}",
            class.inherits
        );
        assert!(
            class
                .inherits
                .contains(&"\\gen\\commands\\command".to_owned()),
            "{:?}",
            class.inherits
        );
    }

    #[test]
    fn locates_magic_properties_at_their_phpdoc_declarations() {
        let directory = tempfile::tempdir().expect("temporary directory");
        let path = directory.path().join("ControllerEx.php");
        let source = br#"<?php
/**
 * @property \App\Models\User $t_user
 * @property-read
 *   \App\Models\UserToken
 *   $t_user_token
 * @property-write \App\Models\UserTokenSubToken $t_user_token_sub_token
 */
class ControllerEx {}
"#
        .to_vec();
        fs::write(&path, &source).expect("write PHP fixture");

        let tags = scan(&path, directory.path(), source, false).expect("scan PHPDoc fixture");
        let class = &tags.classes[0];
        let line_for = |name: &str| {
            class
                .members
                .iter()
                .find(|member| member.name == name)
                .unwrap_or_else(|| panic!("missing magic property {name}"))
                .line
        };

        assert_eq!(line_for("t_user"), 3);
        assert_eq!(line_for("t_user_token"), 6);
        assert_eq!(line_for("t_user_token_sub_token"), 7);
    }
}
