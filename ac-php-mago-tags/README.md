# ac-php-mago-tags

`ac-php-mago-tags` is a fast Rust replacement for the bundled PHP tag generator.
It uses Mago's parser, name resolver, and PHPDoc scanner, then writes the same
Emacs Lisp data consumed by `ac-php`:

- `tags.el` for project sources;
- `tags-vendor.el` for Composer dependencies;
- `mago-cache/files/*.postcard` for incremental per-file results.

This is an ac-php tag generator, not a standard etags/Exuberant Ctags writer.

## Requirements

- Rust 1.97 or newer;
- the PHP version accepted by Mago 1.47.4.

Mago dependencies are pinned to one exact release because the public Rust API is
not stable before Mago 2.0.

## Build

```sh
cargo build --release
```

The executable is written to `target/release/ac-php-mago-tags`.

## Use

```sh
ac-php-mago-tags \
  --workspace /path/to/project \
  --config-file /path/to/project/.ac-php-conf.json \
  --output-dir /path/to/ac-php-cache
```

Force a full rebuild:

```sh
ac-php-mago-tags --workspace /path/to/project --output-dir /tmp/tags --rebuild
```

The configuration reader supports these existing ac-php fields:

- `tag-dir`;
- `filter.php-file-ext-list`;
- `filter.php-path-list`;
- `filter.php-path-list-without-subdir`;
- `filter.ignore-ruleset`.

Files below a path component named `vendor` are written to `tags-vendor.el`.
Vendor file indexes precede project indexes, matching ac-php's merge behavior.

## Verify

```sh
cargo test
cargo run --release -- \
  --workspace ../phptest \
  --config-file ../phptest/.ac-php-conf.json \
  --output-dir /tmp/ac-php-mago-tags-test \
  --rebuild
emacs --batch -Q -l /tmp/ac-php-mago-tags-test/tags.el
```

