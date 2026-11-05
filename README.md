# ac-php

PHP completion, type inference, and code navigation for GNU Emacs, with
frontends for [auto-complete][auto-complete] and [company-mode][company].

ac-php indexes project sources and Composer dependencies, then combines that
index with native PHP types and PHPDoc annotations to provide completion and
jump to definition. It supports both the Mago-based Rust tag generator and the
bundled PHP generator.

| Package | Purpose | MELPA | MELPA Stable |
| --- | --- | --- | --- |
| `ac-php-core` | Shared indexing, type inference, completion, and navigation | [![MELPA](https://melpa.org/packages/ac-php-core-badge.svg)](https://melpa.org/#/ac-php-core) | [![MELPA Stable](https://stable.melpa.org/packages/ac-php-core-badge.svg)](https://stable.melpa.org/#/ac-php-core) |
| `ac-php` | Completion source for auto-complete | [![MELPA](https://melpa.org/packages/ac-php-badge.svg)](https://melpa.org/#/ac-php) | [![MELPA Stable](https://stable.melpa.org/packages/ac-php-badge.svg)](https://stable.melpa.org/#/ac-php) |
| `company-php` | Completion backend for company-mode | [![MELPA](https://melpa.org/packages/company-php-badge.svg)](https://melpa.org/#/company-php) | [![MELPA Stable](https://stable.melpa.org/packages/company-php-badge.svg)](https://stable.melpa.org/#/company-php) |

The repository also includes `helm-ac-php-apropros.el` for searching the project
index with [Helm][helm]. See the [screenshots](screenshots/README.md) for examples.

## Contents

- [Installation](#installation)
- [Quick start](#quick-start)
- [Tag generators](#tag-generators)
- [Project configuration and tags](#project-configuration-and-tags)
- [Completion and type inference](#completion-and-type-inference)
- [Commands](#commands)
- [Project completion providers](#project-completion-providers)
- [Troubleshooting](#troubleshooting)
- [Development](#development)
- [License](#license)

## Installation

### Requirements

- GNU Emacs 24.4 or later.
- [php-mode][php-mode] and one of the completion frontends above.
- PHP CLI for the bundled `phpctags` backend and common fallback tags outside a
  project.

MELPA installs the Emacs package dependencies for the frontend you choose,
including `ac-php-core`. The core uses `s`, `f`, `popup`, `dash`, and `xcscope`;
auto-complete also uses `yasnippet`. The external [Cscope][cscope] program is
optional.

The Mago generator is an optional native executable. Prebuilt binaries do not
require Rust; see [Tag generators](#tag-generators) for installation options.

### Install from MELPA

Add MELPA to your Emacs configuration if it is not already configured:

```elisp
(require 'package)
(add-to-list 'package-archives
             '("melpa" . "https://melpa.org/packages/") t)
(package-initialize)
```

For tagged releases, use MELPA Stable instead:

```elisp
(require 'package)
(add-to-list 'package-archives
             '("melpa-stable" . "https://stable.melpa.org/packages/") t)
(package-initialize)
```

Run `M-x package-refresh-contents`, then install the frontend you want:

- `M-x package-install RET ac-php RET` for auto-complete.
- `M-x package-install RET company-php RET` for company-mode.

See [MELPA Getting Started][melpa-guide] for package archive setup details.

## Quick start

Choose a frontend, then initialize your PHP project.

### auto-complete

Add this to your Emacs configuration:

```elisp
(require 'php-mode)
(require 'ac-php)

(add-hook 'php-mode-hook
          (lambda ()
            (setq-local ac-sources '(ac-source-php))
            (auto-complete-mode 1)
            (yas-minor-mode 1)
            ;; Optional: show signatures in the echo area.
            (ac-php-core-eldoc-setup)))
```

Use `M-x auto-complete` to trigger completion manually.

### company-mode

Add this to your Emacs configuration:

```elisp
(require 'php-mode)
(require 'company-php)

(add-hook 'php-mode-hook
          (lambda ()
            (setq-local company-backends
                        '((company-ac-php-backend company-dabbrev-code)
                          company-capf company-files))
            (company-mode 1)
            ;; Optional: show signatures in the echo area.
            (ac-php-core-eldoc-setup)))
```

Use `M-x company-complete` to trigger completion manually.

### Initialize a project

Create a project marker at the root of your PHP project:

```sh
cd /path/to/project
touch .ac-php-conf.json
```

Open a PHP file in that project and run `M-x ac-php-remake-tags`. ac-php fills an
empty configuration file with defaults and builds the index in the background.
Wait for the successful re-indexing message before requesting project
completion.

A project containing either `.projectile` or `vendor/autoload.php` can also be
detected automatically. In that case, ac-php creates `.ac-php-conf.json` when it
reads the project configuration. See [Project configuration and
tags](#project-configuration-and-tags) to customize the files being indexed.

### Optional navigation keys

These bindings work with either frontend:

```elisp
(with-eval-after-load 'php-mode
  (define-key php-mode-map (kbd "M-]") #'ac-php-find-symbol-at-point)
  (define-key php-mode-map (kbd "M-[") #'ac-php-location-stack-back))
```

For Spacemacs integration, see its [PHP layer][spacemacs-php].

## Tag generators

Both generators write the ac-php-specific Emacs Lisp index used by completion
and navigation. This is a separate format from standard ctags or etags files.

The `ac-php-tags-backend` variable selects the generator:

| Value | Behavior |
| --- | --- |
| `auto` (default) | Use Mago when `ac-php-mago-tags-executable` is executable; otherwise use the bundled PHP generator. |
| `mago` | Require the Mago executable configured by `ac-php-mago-tags-executable`. |
| `phpctags` | Always use the bundled PHP generator. |

### Install Mago from a release

The [GitHub Releases][releases] include `ac-php-mago-tags` archives for these
platforms:

| System | Architecture | Archive suffix |
| --- | --- | --- |
| Linux | x86_64 | `linux-x86_64.tar.gz` |
| Linux | ARM64 / aarch64 | `linux-aarch64.tar.gz` |
| macOS | Intel | `macos-x86_64.tar.gz` |
| macOS | Apple Silicon | `macos-aarch64.tar.gz` |

Download the archive for your platform and its accompanying `SHA256SUMS` file.
Verify the archive checksum, extract it, and install the executable in a
directory visible to Emacs. For example, for the v2.8.3 Linux x86_64 archive:

```sh
mkdir -p ~/.local/bin
tar -xzf ac-php-mago-tags-v2.8.3-linux-x86_64.tar.gz
install -m 755 \
  ac-php-mago-tags-v2.8.3-linux-x86_64/ac-php-mago-tags \
  ~/.local/bin/ac-php-mago-tags
```

With `ac-php-mago-tags` on Emacs's `exec-path`, the default `auto` backend selects
it automatically. To specify its location explicitly:

```elisp
(setq ac-php-tags-backend 'mago
      ac-php-mago-tags-executable "/path/to/ac-php-mago-tags")
```

### Build Mago from source

Building requires Rust 1.97 or later, as declared in
[Cargo.toml](ac-php-mago-tags/Cargo.toml). From the repository root:

```sh
cargo build --manifest-path ac-php-mago-tags/Cargo.toml --release --locked
```

The executable is written to
`ac-php-mago-tags/target/release/ac-php-mago-tags`. Install it as above or point
`ac-php-mago-tags-executable` to that file. See the [generator
README](ac-php-mago-tags/README.md) for CLI usage and incremental cache details.

### Use the bundled PHP generator

ac-php ships with its own modified [phpctags][phpctags]; no separate download is
needed. To select it explicitly:

```elisp
(setq ac-php-tags-backend 'phpctags)
```

Emacs must be able to locate PHP CLI. If necessary, set
`ac-php-php-executable` to the absolute path of your `php` executable.

## Project configuration and tags

### Configuration file

`.ac-php-conf.json` identifies the project root and controls indexing. This
example scans PHP files recursively from the project root while excluding
vendor test files:

```json
{
  "tag-dir": null,
  "filter": {
    "php-file-ext-list": ["php"],
    "php-path-list": ["."],
    "php-path-list-without-subdir": [],
    "ignore-ruleset": [
      "/vendor/**/[tT]ests/**/*.php"
    ]
  }
}
```

| Field | Purpose |
| --- | --- |
| `tag-dir` | Override the tag output directory. `null` uses the default cache. Relative paths are resolved from the project root. |
| `filter.php-file-ext-list` | File extensions to index, without the leading dot. |
| `filter.php-path-list` | Directories to scan recursively, relative to the project root. |
| `filter.php-path-list-without-subdir` | Directories to scan without descending into subdirectories. |
| `filter.ignore-ruleset` | Exclusion rules using gitignore-style patterns. |

Parsed configuration is cached and reread only when its file signature changes.
For projects accessed through TRAMP, ac-php checks the configuration at most once
every five seconds, so repeated completion requests reuse it without fetching
the file. External configuration changes become visible on the next check.
Customize `ac-php-remote-config-check-interval` to adjust this delay, or set it to
zero to check on every lookup. Remote configuration files are never created or
populated automatically.

To include additional PHP library declarations, you can install
[PhpStorm stubs][phpstorm-stubs] in the project:

```sh
composer require --dev jetbrains/phpstorm-stubs
```

### Tag storage

By default, each project has its own directory:

```text
~/.cache/ac-php/tags-<SHA-256>/
```

The digest is derived from the normalized project path. Customize
`ac-php-tags-path` to change the base cache directory, or set `tag-dir` in the
project configuration to choose a specific output directory. Both generators
use that resolved directory.

`tags.el` stores project symbols, and `tags-vendor.el` stores Composer dependency
symbols. With Mago, `mago-cache/` also holds incremental per-file results.

When upgrading from the older path-based cache layout, ac-php creates a fresh
index in the new directory and leaves old cache files in place. Explicit
`tag-dir` settings continue to select the configured directory.

### Updating the index

Run `M-x ac-php-remake-tags` after changing source files. To force a full rebuild,
run `M-x ac-php-remake-tags-all`.

Mago reuses unchanged file results. On normal incremental runs, it also reuses
the vendor index when `composer.lock` is unchanged and `tags-vendor.el` exists.
Use a full rebuild after editing vendor sources directly or changing indexing
filters. Indexing from a file inside `vendor/` automatically forces a rebuild.

ac-php also requests an update when an index is older than
`ac-php-auto-update-intval`, which defaults to 3,600 seconds. Indexing runs in the
background, and different projects can be indexed independently.

## Completion and type inference

Both frontends share the same core type resolution and completion logic.
Completion covers classes, members, functions, constants, and variables, with
support for namespaces, imports, inheritance, and chained member access.

### Native types and PHPDoc

ac-php uses native parameter, return, and property types, together with PHPDoc
annotations such as `@param`, `@return`, `@var`, `@property`, `@property-read`,
`@property-write`, and `@method`.

```php
use Acme\Services\HelloService;

/**
 * @property-read HelloService $hello
 * @method HelloService createHello()
 */
class Example
{
    public HelloService $service;

    public function greet(HelloService $service): HelloService
    {
        return $service;
    }
}

/** @var HelloService $hello */
$hello = create_service();
```

Add PHPDoc when a native declaration or inferred expression does not provide
enough type information.

### Array shapes and imported type aliases

Array key completion understands PHPStan array shapes, `@phpstan-type`, and
`@phpstan-import-type`, including aliases renamed with `as` and aliases referenced
by an imported shape.

```php
/**
 * @phpstan-type Options array{title?: string, capabilities?: array{export?: bool}}
 */
final class ConfigTypes {}

/** @phpstan-import-type Options from ConfigTypes as Overrides */
class BrokerConfig
{
    /** @return Overrides */
    protected static function get_overrides(): array
    {
        return ['capabilities' => ['export' => false]];
    }
}
```

Keys are completed in quoted array offsets and in array literals used as typed
call arguments, return values, or assignments annotated with `@var`. Completion
follows nested shapes, lists, and maps.

In an array literal key slot, completion also works before the opening quote.
Selecting a key inserts `'key' => ` and excludes keys already present in the
current array.

Imported source classes are resolved through project tags and PHP namespace or
`use` declarations. Classes in the same file or a neighboring `ClassName.php`
can also be read without tags. Jump to definition on an imported or renamed
alias opens its original `@phpstan-type` declaration.

### Named arguments

Complete parameter names as `name: ` in function, method, and constructor calls.
Parameters already supplied by name or position are excluded, and an existing
colon is preserved. Jump to definition on a named argument label opens the
matching parameter declaration.

### String literal arguments

PHPDoc can constrain an argument to a set of string values:

```php
class Article
{
    /** @param 'draft'|'ready' $status */
    public function set_status($status) {}

    public function publish()
    {
        $this->set_status('');
    }
}
```

Request completion inside the quoted argument to choose `draft` or `ready`.
This also supports string literal constraints on type parameters in magic
`@method` declarations.

## Commands

Run these commands with `M-x`:

| Command | Description |
| --- | --- |
| `ac-php-remake-tags` | Update the project index incrementally. |
| `ac-php-remake-tags-all` | Force a full rebuild, including vendor tags. |
| `ac-php-find-symbol-at-point` | Jump to a symbol, named parameter, PHPDoc type alias, or included file. |
| `ac-php-location-stack-back` | Return to the previous location. |
| `ac-php-location-stack-forward` | Move forward through navigation history. |
| `ac-php-show-tip` | Show documentation for the symbol at point. |
| `ac-php-toggle-debug` | Toggle debug messages. |
| `helm-ac-php-apropos` | Search the project index with Helm. |
| `helm-ac-php-apropos-at-point` | Search with the symbol at point as the initial query. |

`ac-php-show-tip` and the documentation views in auto-complete and company-mode
include source PHPDoc below a compact signature, return type, visibility, and
declaring class. The symbol tooltip distinguishes the header elements with
colors on its normal background, keeps them on one logical line, and wraps when
space is limited. Headers omit the `[system]` and `[user]` origin labels.
PHPDoc displays remove common HTML markup and excess blank lines. Documentation
is read on demand from project or dependency sources, preferring unsaved Emacs
buffers. Inherited members use their declaring class's documentation; magic
members show the matching `@method` or `@property` annotation. Constructor
candidates show the constructor's PHPDoc, or the class PHPDoc when there is no
constructor. Symbols without available source keep their signature information.
`@inheritdoc` references are displayed as written rather than expanded.

The Helm commands require Helm and `helm-ac-php-apropros.el`. When loading it
explicitly, use `(require 'helm-ac-php-apropros)`; the filename and feature name
retain that spelling.

## Project completion providers

Projects can add completion contexts through
`ac-php-extra-completion-functions`. Providers are tried until one returns a
non-nil result. Each provider receives `tags-data`:

- When `tags-data` is nil, the frontend is only requesting the prefix.
- Return nil when the provider is inactive, so normal completion can continue.
- Otherwise, return a plist with `:prefix` and, when tags data is supplied,
  `:candidates`. Candidate strings may carry normal ac-php text properties.

The following sketch uses `my-project-context-p` as a placeholder for your own
context check:

```elisp
(defun my-php-extra-completion (tags-data)
  (when (my-project-context-p)
    (if tags-data
        (list :prefix "item"
              :candidates (list (propertize "item_id"
                                            'ac-php-return-type "int")))
      (list :prefix "item"))))

(add-hook 'ac-php-extra-completion-functions
          #'my-php-extra-completion)
```

The core candidate API, company-mode, and auto-complete all use the same provider.

## Troubleshooting

### Project root cannot be resolved

Create `.ac-php-conf.json` in the project root, then run
`M-x ac-php-remake-tags` from a PHP buffer inside the project. A `.projectile`
file or `vendor/autoload.php` is also sufficient for root detection.

Outside a recognized project, both rebuild commands report a user error and
leave indexing available for other projects.

Older versions could leave `ac-php-gen-tags-flag` set after a missing-root
error, causing later rebuild commands to do nothing. After upgrading, restart
Emacs or reload the updated `ac-php-core.el` with `M-x load-file`. Evaluate
`(symbol-file 'ac-php--remake-tags 'defun)` to check which copy Emacs is using
if another installation still appears to be active.

### Completion is missing or stale

Check that the correct frontend is enabled and the files you need are included
by the project configuration. Run `M-x ac-php-remake-tags-all` and wait for
indexing to finish.

If you selected Mago explicitly, ensure the configured executable is available
to Emacs. For the PHP backend, check `ac-php-php-executable`. A graphical Emacs
session may have a different executable search path from your shell.

### Indexing fails

Inspect `*Messages*` for indexing status and reported errors. To log the
generator command and output, enable `M-x ac-php-toggle-debug` and rerun
indexing. For parser errors, check the reported source location and rerun
indexing after correcting the problem.

When reporting an issue, include your Emacs and PHP versions, the selected tag
backend and its version, your frontend configuration, relevant generator
output, and a small PHP example that reproduces the behavior. See this
[example issue][issue-example] for a reproducible report.

## Development

### Emacs Lisp

The Cask development environment requires Emacs 25.1 or later. Install
[Cask][cask], then run these commands from the repository root:

```sh
make init
make test
make build
```

`make init` installs dependencies, `make test` runs Emacs's built-in ERT suite,
and `make build` byte-compiles the four Emacs Lisp modules. `TESTFLAGS` supplies
additional Emacs batch arguments; the old `ert-runner` reporter options are not
supported.

Dependencies are installed per Emacs major/minor version, for example
`.cask/31.1/elpa`. Run `make init` again after upgrading Emacs. Once the selected
version's dependencies are installed, tests and builds can reuse that local
directory without Cask; installing or updating dependencies still requires it.

The Makefile finds Emacs and Cask on `PATH`, with fallbacks to
`/Applications/Emacs.app/Contents/MacOS/Emacs` and `~/.cask/bin/cask`. Override
locations when needed:

```sh
make init EMACS=/path/to/emacs CASK=/path/to/cask
make test EMACS=/path/to/emacs CASK=/path/to/cask
```

`CASK_EMACS` defaults to the selected `EMACS`, keeping dependency installation
and tests on the same version.

To copy local sources into existing package installations, run `./cp2elpa.sh`.
It scans `~/.emacs.d/elpa/*/*/` by default. To select a specific package directory:

```sh
PACKAGE_USER_DIR="$HOME/.emacs.d/elpa/31.1/develop" ./cp2elpa.sh
```

The script updates installed packages and removes their stale bytecode. Restart
Emacs or use `M-x load-file` to reload the updated `ac-php-core.el` and installed
frontend files; copying files does not replace functions already loaded in memory.

### Rust generator

From the repository root, run:

```sh
cargo fmt --manifest-path ac-php-mago-tags/Cargo.toml --all -- --check
cargo test --manifest-path ac-php-mago-tags/Cargo.toml --locked
cargo clippy --manifest-path ac-php-mago-tags/Cargo.toml --all-targets --locked -- -D warnings
cargo build --manifest-path ac-php-mago-tags/Cargo.toml --release --locked
```

For generator changes, also generate tags from the example project and verify
that Emacs can load both outputs:

```sh
ac_php_tags_dir="$(mktemp -d)"
cargo run --manifest-path ac-php-mago-tags/Cargo.toml --release --locked -- \
  --workspace phptest \
  --config-file phptest/.ac-php-conf.json \
  --output-dir "$ac_php_tags_dir" \
  --rebuild
emacs -Q --batch \
  -l "$ac_php_tags_dir/tags-vendor.el" \
  -l "$ac_php_tags_dir/tags.el"
```

### Repository guide

| Path | Purpose |
| --- | --- |
| `ac-php-core.el` | Shared implementation; maintained as a single file for package distribution. |
| `ac-php.el`, `company-php.el` | Frontend adapters and completion insertion. |
| `helm-ac-php-apropros.el` | Helm project index search. |
| `ac-php-mago-tags/` | Rust tag generator. |
| `test/` | ERT tests and fixtures. |
| `phptest/` | Example PHP project and indexing inputs. |

See [AGENTS.md](AGENTS.md) for repository conventions, the [core design
notes](docs/ac-php-core-redesign.md) for implementation structure, and
[RELEASING.md](RELEASING.md) for the release process. Run `git diff --check`
before submitting changes.

## License

ac-php is licensed under the GNU General Public License, version 3 or later.

[auto-complete]: https://github.com/auto-complete/auto-complete
[company]: https://github.com/company-mode/company-mode
[php-mode]: https://github.com/emacs-php/php-mode
[helm]: https://github.com/emacs-helm/helm
[cscope]: https://cscope.sourceforge.net/
[melpa-guide]: https://melpa.org/#/getting-started
[spacemacs-php]: https://github.com/syl20bnr/spacemacs/tree/develop/layers/%2Blang/php
[releases]: https://github.com/xcwen/ac-php/releases
[phpctags]: https://github.com/xcwen/phpctags
[phpstorm-stubs]: https://github.com/JetBrains/phpstorm-stubs
[issue-example]: https://github.com/xcwen/ac-php/issues/51
[cask]: https://github.com/cask/cask
