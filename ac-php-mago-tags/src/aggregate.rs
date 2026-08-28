use std::collections::{BTreeMap, BTreeSet, HashMap};

use crate::model::{GlobalTag, IndexedFile, MemberKind, OutputClass, OutputMember, TagSet};

pub fn aggregate(files: &[IndexedFile]) -> TagSet {
    let mut classes: BTreeMap<String, OutputClass> = BTreeMap::new();
    let mut globals = Vec::new();
    let mut inherits: BTreeMap<String, BTreeSet<String>> = BTreeMap::new();
    let mut constructors: HashMap<String, (String, String)> = HashMap::new();
    let mut definitions: HashMap<String, String> = HashMap::new();

    for indexed in files {
        for class in &indexed.tags.classes {
            let location = format!("{}:{}", indexed.index, class.line);
            definitions.insert(class.name.clone(), location.clone());
            globals.push(GlobalTag {
                kind: class.kind.legacy_kind().to_owned(),
                name: class.name.clone(),
                args: String::new(),
                location,
                return_type: class.name.clone(),
            });

            let output = classes
                .entry(class.name.clone())
                .or_insert_with(|| OutputClass {
                    name: class.name.clone(),
                    members: Vec::new(),
                });
            inherits
                .entry(class.name.clone())
                .or_default()
                .extend(class.inherits.iter().cloned());

            for member in &class.members {
                let location = format!("{}:{}", indexed.index, member.line);
                if member.kind == MemberKind::Method
                    && member.name.eq_ignore_ascii_case("__construct")
                {
                    constructors
                        .insert(class.name.clone(), (member.args.clone(), location.clone()));
                }
                output.members.push(OutputMember {
                    kind: member.kind.legacy_kind().to_owned(),
                    name: if member.kind == MemberKind::Method {
                        format!("{}(", member.name)
                    } else {
                        member.name.clone()
                    },
                    args: member.args.clone(),
                    location,
                    return_type: member.return_type.clone(),
                    class_name: class.name.clone(),
                    access: member.access.clone(),
                    is_static: member.is_static,
                });
            }
        }

        for function in &indexed.tags.functions {
            globals.push(GlobalTag {
                kind: "f".to_owned(),
                name: format!("{}(", function.name),
                args: function.args.clone(),
                location: format!("{}:{}", indexed.index, function.line),
                return_type: function.return_type.clone(),
            });
        }
        for constant in &indexed.tags.constants {
            globals.push(GlobalTag {
                kind: "d".to_owned(),
                name: constant.name.clone(),
                args: String::new(),
                location: format!("{}:{}", indexed.index, constant.line),
                return_type: constant.return_type.clone(),
            });
        }
    }

    for class_name in classes.keys() {
        let constructor = find_constructor(class_name, &constructors, &inherits).or_else(|| {
            definitions
                .get(class_name)
                .map(|location| (String::new(), location.clone()))
        });
        if let Some((args, location)) = constructor {
            globals.push(GlobalTag {
                kind: "f".to_owned(),
                name: format!("{class_name}("),
                args,
                location,
                return_type: class_name.clone(),
            });
        }
    }

    for class in classes.values_mut() {
        class
            .members
            .sort_by(|a, b| (&a.location, &a.name).cmp(&(&b.location, &b.name)));
    }
    globals.sort_by(|a, b| (&a.name, &a.location).cmp(&(&b.name, &b.location)));

    TagSet {
        classes: classes.into_values().collect(),
        globals,
        inherits: inherits
            .into_iter()
            .map(|(name, values)| (name, values.into_iter().collect()))
            .collect(),
        files: files.iter().map(|file| file.tags.path.clone()).collect(),
    }
}

fn find_constructor(
    class_name: &str,
    constructors: &HashMap<String, (String, String)>,
    inherits: &BTreeMap<String, BTreeSet<String>>,
) -> Option<(String, String)> {
    let mut current = class_name.to_owned();
    let mut seen = BTreeSet::new();
    while seen.insert(current.clone()) {
        if let Some(constructor) = constructors.get(&current) {
            return Some(constructor.clone());
        }
        current = inherits.get(&current)?.iter().next()?.clone();
    }
    None
}
