#!/bin/bash

set -euo pipefail
shopt -s nullglob

# Override the installed package root, or use a glob for several Emacs versions:
#   PACKAGE_USER_DIR=~/.local/state/emacs/elpa ./cp2elpa.sh
#   PACKAGE_USER_DIR="$HOME/.emacs.d/elpa/31.1/develop" ./cp2elpa.sh
: "${PACKAGE_USER_DIR:=$HOME/.emacs.d/elpa/*/*/}"

script_directory="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
updated_packages=0

update_package() {
    local package_directory="$1"
    shift

    cp -f -- "$@" "$package_directory/"
    rm -f -- "$package_directory"/*.elc
    printf 'Updated %s\n' "$package_directory"
    updated_packages=$((updated_packages + 1))
}

while IFS= read -r package_root; do
    [[ -d "$package_root" ]] || continue

    for package_directory in "$package_root"/ac-php-core-[0-9]*; do
        [[ -d "$package_directory" ]] || continue
        update_package "$package_directory" \
            "$script_directory/ac-php-core.el" \
            "$script_directory/phpctags" \
            "$script_directory"/ac-php-comm-tags-data.* \
            "$script_directory/helm-ac-php-apropros.el"
        chmod a-w "$package_directory"/*.el
    done

    for package_directory in "$package_root"/ac-php-[0-9]*; do
        [[ -d "$package_directory" ]] || continue
        update_package "$package_directory" "$script_directory/ac-php.el"
    done

    for package_directory in "$package_root"/company-php-[0-9]*; do
        [[ -d "$package_directory" ]] || continue
        update_package "$package_directory" "$script_directory/company-php.el"
    done
done < <(
    if [[ -d "$PACKAGE_USER_DIR" ]]; then
        printf '%s\n' "$PACKAGE_USER_DIR"
    else
        compgen -G "$PACKAGE_USER_DIR" || true
    fi
)

if [[ "$updated_packages" -eq 0 ]]; then
    printf 'No installed ac-php packages found under %s\n' "$PACKAGE_USER_DIR" >&2
    exit 1
fi

printf 'Updated %s package directories. Restart Emacs or reload the updated .el files to use them.\n' \
    "$updated_packages"
