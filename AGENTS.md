# 仓库协作指南

本文件适用于整个仓库。修改前阅读相关实现与现有测试；优先做与任务直接相关的小范围改动。

## 项目定位与目录

ac-php 是为 PHP 提供补全、类型推断和定义跳转的 Emacs 插件，主体是 Emacs Lisp，并包含一个 Rust 标签生成器。`phptest/` 中的 PHP 文件是示例与测试输入，不是 PHP Web 应用。

| 路径 | 职责 |
| --- | --- |
| `ac-php-core.el` | 项目配置、标签后端选择、标签加载与缓存、PHP/PHPDoc 解析、类型推断、候选项和定义跳转 |
| `ac-php.el` | `auto-complete` 前端与补全插入逻辑 |
| `company-php.el` | `company-mode` 后端与补全插入逻辑 |
| `helm-ac-php-apropros.el` | 基于标签索引的 Helm 搜索界面；保留现有文件名和 feature 拼写 |
| `ac-php-mago-tags/` | 基于 Mago 的 Rust 标签生成器，独立 Cargo 项目 |
| `~/phpctags`（本机 `/Users/jim/phpctags`） | 随包 PHP 标签生成器的源码仓库；本仓库的 `phpctags_src` 链接指向此目录 |
| `test/*-test.el` | ERT 自动化测试 |
| `test/test-helper.el` | 测试依赖加载、临时 PHP buffer 和 fixture 辅助宏 |
| `test/dev-env.el` | 无 Cask CLI 时为测试和字节编译加载当前 Emacs 版本的本地依赖 |
| `test/fixtures/` | 自动化测试使用的 PHP 输入 |
| `phptest/` | PHP 示例项目及 `.ac-php-conf.json`，可用于标签生成验证 |
| `Cask`、`Makefile` | Emacs 包依赖、字节编译与测试入口 |
| `RELEASING.md` | 版本更新、验证和发布流程 |

Rust 模块按职责划分：`config.rs` 读取配置，`discover.rs` 发现源文件，`scanner.rs` 提取 PHP/PHPDoc 符号，`model.rs` 定义数据与缓存版本，`aggregate.rs` 聚合并分配文件索引，`emacs.rs` 输出 Lisp，`cache.rs` 管理增量缓存，`main.rs` 编排 CLI 与扫描流程。

## 开发与验证命令

以下命令均从仓库根目录执行。按改动范围选择检查；只改文档时检查内容和差异即可。

### Emacs Lisp

```sh
make init       # 使用 Cask 安装项目依赖
make test       # 运行完整 ERT 测试
make build      # 字节编译四个 Emacs Lisp 模块
```

- `Makefile` 支持覆盖 `EMACS`、`CASK` 和 `CASK_EMACS`。macOS 上找不到 PATH 中的 Emacs 时，会尝试 `/Applications/Emacs.app/Contents/MacOS/Emacs`。
- Emacs 31.1 的开发依赖位于 `.cask/31.1/elpa`。升级 Emacs 后重新运行 `make init`，不能以旧版本的依赖目录存在作为初始化成功的依据。
- 测试统一使用 Emacs 内置 ERT；`TESTFLAGS` 是额外的 Emacs batch 参数，不再接受旧 `ert-runner` 的 reporter 参数。不要重新启用会覆盖内置 ERT 的遗留 autoload。
- 找不到 Cask 时，测试和字节编译通过 `test/dev-env.el` 加载与当前 Emacs 主次版本匹配的 `.cask/<major>.<minor>/elpa`；这仍要求该版本的依赖已经安装。
- `make init` 安装或更新依赖时需要 Cask。无 Cask 的编译和测试只复用当前 Emacs 版本已安装的依赖。
- 单独运行某个测试文件时，先加载 helper，再加载测试文件。例如，在 Emacs 可通过 PATH 找到且本地依赖已就绪时：

```sh
emacs -Q --batch -L . -L test \
  -l test/test-helper.el \
  -l test/ac-php-parser-test.el \
  -f ert-run-tests-batch-and-exit
```

若依赖依靠 Cask 提供，可在上述 `emacs` 命令前加 `cask exec`。测试 helper 设置了 `load-prefer-newer`，避免加载比源文件旧的 `.elc`。

### Rust 标签生成器

工具链要求以 `ac-php-mago-tags/Cargo.toml` 为准，目前最低 Rust 版本为 1.97。使用与发布工作流兼容的工具链。

```sh
cargo fmt --manifest-path ac-php-mago-tags/Cargo.toml --all -- --check
cargo test --manifest-path ac-php-mago-tags/Cargo.toml --locked
cargo clippy --manifest-path ac-php-mago-tags/Cargo.toml --all-targets --locked -- -D warnings
cargo build --manifest-path ac-php-mago-tags/Cargo.toml --release --locked
```

修改生成格式或扫描流程时，除单元测试外，用示例项目生成标签，并确认 Emacs 能加载输出。输出写入临时目录：

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

所有改动结束后执行 `git diff --check`。说明实际运行的验证；如果缺少依赖或工具链，明确列出未完成的检查及原因。

## 实现约定

### Emacs Lisp 与补全行为

- **保持 `ac-php-core.el` 为单文件实现，不拆分为多个 `.el` 文件。** MELPA recipe 只指定了该核心文件；重构通过文件内职责分区、共享辅助函数和数据结构整合完成，不新增核心必须 `require` / `load` 的本地实现文件。修改本仓库的 `Cask` 或 `Makefile` 不会自动改变 MELPA 的收录范围。
- 遵循邻近代码的 Emacs Lisp 缩进、命名和 docstring 风格；保留文件头、许可证、autoload 标记和 `provide`。注释与 docstring 沿用现有英文风格。
- 核心符号使用 `ac-php-` 前缀，Company 前端沿用 `company-ac-php-`。避免引入与项目无关的通用全局变量。
- 类型解析、PHPDoc、候选项构造和上下文判断优先放入核心，前端负责适配和插入行为。共享能力应同时适用于 `auto-complete` 与 `company-mode`。
- 项目专用补全可使用已有的 `ac-php-extra-completion-functions` 扩展点。保持 provider 在 `tags-data` 为 nil 时查询 prefix 的约定，以及未激活时返回 nil 的回退行为。
- 修改候选项时保留供前端使用的 text properties；验证 prefix、过滤、插入文本和光标位置，而不只是候选项字符串。
- 修改解析逻辑时注意 Emacs buffer、point、窄化和正则匹配状态；用现有的 `with-ac-php-buffer-test` 或 `with-ac-php-file-test` 构造回归用例。
- README 与包头仍声明支持 Emacs 24.4，`Cask` 则声明 25.1。没有明确的兼容性调整任务时，避免无意引入仅新版本 Emacs 提供的 API，也不要顺手修改最低版本声明。

### 标签协议与缓存

- `ac-php-tags-backend` 支持 `auto`、`mago`、`phpctags`；`auto` 优先使用可执行的 Mago 生成器，否则回退到随包提供的 `phpctags`。保留后端选择及显式配置的行为。
- `.ac-php-conf.json` 是 PHP 项目配置。维护 `tag-dir` 和现有 `filter` 字段的兼容性，避免把本机绝对路径写入共享配置。
- 默认标签目录使用规范化项目路径的 SHA-256 摘要，避免路径分隔符与连字符混用导致目录冲突。PHP 后端通过 `--output-dir` 接收完整输出目录；修改此参数时同步维护 `~/phpctags` 源码与本仓库的打包文件。
- Rust 输出的是 ac-php 专用 Lisp 数据，不是标准 ctags/etags。修改格式时同时检查 `emacs.rs`、`aggregate.rs` 和 `ac-php-core.el` 中的读取与合并逻辑。
- 保持 `tags.el`、`tags-vendor.el`、`g-ac-php-tmp-tags` 数据容器、各向量字段顺序和文件索引一致；vendor 文件索引先于项目文件索引。成员向量第九个字段保存带类型的参数信息。
- Emacs 内存缓存需要在项目标签或 vendor 标签变化时失效；只更新 `tags-vendor.el` 也必须刷新合并数据。
- Rust 使用文件元数据和内容哈希复用结果；vendor 阶段依据 `composer.lock` 的签名和 vendor 标签是否存在决定是否重建。修改缓存时验证首次扫描、增量复用、源文件变化和 `--rebuild` 路径。
- 缓存序列化格式变化时检查 `model.rs` 的 `CACHE_SCHEMA_VERSION`。Mago 依赖固定为同一精确版本；升级时同步检查所有 `mago-*` 依赖、`Cargo.lock` 和 `model.rs` 的 `MAGO_VERSION`。

## 测试与变更范围

- 修复可观察行为时，优先在对应的 `test/ac-php-*-test.el` 中补充能复现问题的 ERT 用例。跨前端补全行为应覆盖两个前端；Rust 的测试沿用模块内 `#[cfg(test)]` 的组织方式。
- PHP fixtures 可能故意包含不完整或无效代码，用于模拟编辑中的 buffer；不要批量修正示例或把全部 PHP 文件通过语法检查作为验收条件。
- `.elc`、`.cask/`、Rust `target/` 和生成的标签/缓存是本地产物，不纳入提交。保留 `ac-php-mago-tags/Cargo.lock`，常规验证使用 `--locked`。
- 根目录 `phpctags` 是已跟踪的打包可执行文件，其源码位于 `~/phpctags`（本机 `/Users/jim/phpctags`）。修改 PHP 标签生成器时从该源码仓库入手，按其构建流程重新生成后再更新打包文件，避免直接编辑打包产物。`phpctags_src` 是指向该源码目录的本机链接，已被 Git 忽略。
- 行为或配置变化时更新对应 README。发布任务按 `RELEASING.md` 同步版本并核对 `.github/workflows/release.yml`；普通修复无需修改发布版本。
- `.github/workflows/blank.yml` 目前只是占位工作流，不运行实际测试；不能用它的成功状态代替本地验证。发布工作流另有 Rust 格式、测试和 Clippy 检查。
