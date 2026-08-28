# Publishing a release

GitHub Actions publishes releases from existing tags. A release contains the
repository source archive, four `ac-php-mago-tags` binary archives, and a
`SHA256SUMS` file.

## 1. Prepare the version

Update the user-visible package versions when appropriate:

- `Version` in `ac-php-core.el`;
- the package version in `Cask`;
- `version` in `ac-php-mago-tags/Cargo.toml`.

Then refresh and verify the Rust lock file:

```sh
cd ac-php-mago-tags
cargo check
cd ..
```

## 2. Verify the release commit

```sh
make test
cargo test --manifest-path ac-php-mago-tags/Cargo.toml --locked
cargo clippy --manifest-path ac-php-mago-tags/Cargo.toml \
  --all-targets --locked -- -D warnings
git diff --check
```

Commit every release file before creating the tag. The workflow builds exactly
the tagged commit, not uncommitted local files.

## 3. Create and push the tag

Use a `v`-prefixed annotated tag:

```sh
git tag -a v2.8.0 -m "ac-php v2.8.0"
git push origin HEAD
git push origin v2.8.0
```

Pushing the tag starts `.github/workflows/release.yml`. The workflow builds:

- `linux-x86_64` using static musl;
- `linux-aarch64` using static musl;
- `macos-x86_64` for Intel Macs;
- `macos-aarch64` for Apple Silicon Macs.

The publish job runs only after all four builds succeed. It creates the GitHub
Release, generates release notes, and attaches all archives and checksums.

## 4. Retry a release

Open the repository's **Actions** page, select **Release**, choose **Run
workflow**, and enter an existing tag. If the release already exists, the
workflow replaces its assets. Release immutability must be disabled to replace
assets on an already published release.

