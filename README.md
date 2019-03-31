# ac-php
[![Build Status][:badge-travis:]][:project-travis:]

A GNU Emacs auto completion source for the PHP.

---

This repository contains:

- **ac-php-core**, the core library of the ac-php
  [![MELPA][:badge-ac-php-core:]][:project-ac-php-core:]
  [![MELPA Stable][:badge-ac-php-core-s:]][:project-ac-php-core-s:]
- **ac-php**, a frontend for the `auto-complete`
  [![MELPA][:badge-ac-php:]][:project-ac-php:]
  [![MELPA Stable][:badge-ac-php-s:]][:project-ac-php-s:]
- **company-php**, a frontend for the `company-mode`
  [![MELPA][:badge-company-php:]][:project-company-php:]
  [![MELPA Stable][:badge-company-php-s:]][:project-company-php-s:]
- **helm-ac-php-apropros**, an apropos functionnality using the ac-php index and `helm` as interface

## Table of Contents

* [Features](#features)
* [Install](#installation)
  * [Using MELPA](#using-melpa)
* [Usage](#usage)
  * [Commands](#commands)
  * [auto-complete](#auto-complete)
  * [company-mode](#company-mode)
  * [Spacemacs](#spacemacs)
  * [PHPDoc annotations](#phpdoc-annotations)
  * [Working with tags](#working-with-tags)
  * [Using configuration file](#using-configuration-file)
  * [Rebuilding tags](#rebuilding-tags)
* [FAQ](#faq)
* [License](#license)

## Features

- Currently ships with [Spacemacs][:gh-spacemacs:]
- Supports of [`auto-complete`][:gh-ac:], [`company-mode`][:gh-company:] and [`helm`][:gh-helm:]
- Auto Completion for built-in extensions
  - PDO
  - SPL
  - mysqli
  - SQLite3
  - ...
- Auto Completion for PECL extesnions
  - Redis
  - Imagick
  - Swoole
  - Memcache
  - ...
- Auto Completion for built-in classes
  - SplFileInfo
  - DOMDocument
  - SimpleXMLElement
  - ...
- Auto Completion for user defined classes
- Auto Completion for built-in functions
- Supports of PHPDoc annotations

For more see [screenshots][:screenshots:] page.

## Installation

Known to work with GNU Emacs 24.4 and later. ac-php may work with older versions of GNU Emacs, or with other flavors of GNU Emacs (e.g. XEmacs) but this is not guaranteed. Bug reports for problems related to using ac-php with older versions of Emacs will most like not be addressed.

Prerequisite packages are:

- **Common**
  - GNU Emacs >= 24.4
  - PHP CLI
  - [php-mode][:gh-php-mode:]
- **`ac-php-core.el`**
  - [s][:melpa-s:]
  - [f][:melpa-f:]
  - [popup][:melpa-popup:]
  - [dash][:elpa-dash:]
  - [scope][:sf-cscope:] (optional)
- **`ac-php.el`**
  - [auto-complete][:gh-ac:]
  - [yasnippet][:gh-yasnippet:]
- **`helm-ac-php-apropros.el`**
  - [helm][:gh-helm:]
- **`company-php.el`**
  - [company][:gh-company:]

### Using MELPA

The best way of installing ac-php, at least for GNU Emacs 24, is to use the packaging system. Add MELPA or MELPA Stable to the list of repositories to access this mode. For those who want only formal, tagged releases use MELPA Stable:

``` elisp
(require 'package)
(add-to-list 'package-archives
             '("melpa-stable" . "https://stable.melpa.org/packages/") t)
(package-initialize)
```
For those who want rolling releases as they happen use MELPA :

``` elisp
(require 'package)
(add-to-list 'package-archives
             '("melpa" . "https://melpa.org/packages/") t)
(package-initialize)
```

and then use `M-x package-refresh-contents` and `M-x package-list-packages` to get to
the package listing and install `ac-php` from there. MELPA tracks this Git repository
and updates relatively soon after each commit or formal release.  For more detail on
setting up see [MELPA Getting Started][:melpa-gs:].

You can install `ac-php` manually by adding following to your init file :

``` elisp
(unless (package-installed-p 'ac-php)
    (package-refresh-contents)
    (package-install 'ac-php))
```

## Usage

### Commands

| Command                       | Description                                                |
| ----------------------------- | ---------------------------------------------------------- |
| `ac-php-remake-tags`          | Run this command to update tags if source has been changed |
| `ac-php-remake-tags-all`      | Run this command if you find an error                      |
| `ac-php-find-symbol-at-point` | Jump to definition                                         |
| `ac-php-location-stack-back`  | Return back                                                |
| `ac-php-show-tip`             | Show definition at point                                   |
| `helm-ac-php-apropos`         | Search through all the definitions of a project with helm  |

### auto-complete

1. Add hook as follows :

``` elisp
(require 'php-mode)

(add-hook 'php-mode-hook
          '(lambda ()
             ;; Enable auto-complete-mode
             (auto-complete-mode t)

             (require 'ac-php)
             (setq ac-sources '(ac-source-php))

             ;; As an example (optional)
             (yas-global-mode 1)

             ;; To enable eldoc support (optional)
             (ac-php-core-eldoc-setup )

             ;; Jump to definition (optional)
             (define-key php-mode-map (kbd "C-]")
               'ac-php-find-symbol-at-point)

             ;; Return back (optional)
             (define-key php-mode-map (kbd "C-t")
               'ac-php-location-stack-back)))
```

2. Create the [configuration file](#using-configuration-file) `.ac-php-conf.json` in the project root :

```sh
$ cd /project/to/poject/root
$ touch .ac-php-conf.json
```

And use `M-x company-complete` to complete.

### company-mode

1. Add hook as follows :

``` elisp
(require 'php-mode)

(add-hook 'php-mode-hook
          '(lambda ()
             ;; Enable company-mode
             (require 'company-php)
             (company-mode t)

             ;; To enable eldoc support (optional)
             (ac-php-core-eldoc-setup )

             (make-local-variable 'company-backends)
             (add-to-list 'company-backends 'company-ac-php-backend)))
```

2. Create the [configuration file](#using-configuration-file) `.ac-php-conf.json` in the project root :

```sh
$ cd /project/to/poject/root
$ touch .ac-php-conf.json
```

And use `M-x company-complete` to complete.

### Spacemacs

To use ac-php with Spacemacs please refer to :
https://github.com/syl20bnr/spacemacs/tree/develop/layers/%2Blang/php

### PHPDoc annotations

ac-php supports of PHPDoc annotations. Thus auto completion should work for:


**Property type hints**

```php
/**
 * @var \Acme\Services\HelloService
 */
public $hello;
```

**Invisible (magic) members**

```php
/**
 * @property \Acme\Services\HelloService $hello
 */
class Test
{
    // ...
}
```

**Return type hins**

```php
/**
 * @return \Acme\Services\HelloService
 */
public function get_v1()

```

**Invisible (magic) methods**

```php
/**
 * @method \Acme\Services\HelloService hello()
 */
class Test
{
    // ...
}
```

**PHP 7 type hints**

```php
public function hello(): \Acme\Services\HelloService
{
    // ...
}
```

**Variable type hins**

```php
/** @var \Acme\Services\HelloService $hello */
$hello = hello();
```

**Note:** if a function or a class member has no defined return value then you need to define it using annotation.

### Working with tags

ac-php uses its own tags format. By default all tags located at `~/.ac-php/tags-<project-directory>`.
For example, if the real path of the project is `/home/jim/ac-php/phptest`, then tags will be placed at
`~/.ac-php/tags-home-jim-ac-php-phptest/`.

And you can redefine the base path (`~/.ac-php`) using `ac-php-tags-path` variable.

The tags directory structure looks loke this:

```bash
$ tree ~/.ac-php/tags-home-jim-ac-php-phptest
tags-home-jim-ac-php-phptest/
├── cache-files.json
├── tags-data-cache2.el
├── tags-data.el
└── tags_dir_jim
    ├── a.el
    ├── dir1-sss.el
    ├── testa.el
    ├── testb.el
    └── testc.el
1 directory, 8 files
```

### Using configuration file

ac-php uses per-project configuration located in the file called `.ac-php-conf.json`.
This file is mandatory for normal operation of auto completion.

When you run `ac-php-remake-tags` and your `.ac-php-conf.json` is empty, default json will be generated.
Its contents will be similar to:

```json
{
  "filter": {
    "php-file-ext-list": [
      "php"
    ],
    "php-path-list": [
      "."
    ],
    "php-path-list-without-subdir": []
  }
}
```

- `php-file-ext-list`: file extern name list
- `php-path-list`:  base path for *recursive* file search to collect tags
- `php-path-list-without-subdir`:  path for *non-recursive* file search to collect tags

for example:

```
├── dir1
│   ├── 1.php
│   └── dir11
│       └── 11.php
├── dir2
│   └── 2.php
└── dir3
    ├── 3.php
    ├── dir31
    │   └── 31.php
    ├── dir32
    │   └── 32.php
    └── dir33
        └── 33.php
```

```json
{
  "filter": {
    "php-file-ext-list": [
      "php"
    ],
    "php-path-list": [
      "./dir1",
      "./dir2",
      "./dir3/dir32/"
    ],
    "php-path-list-without-subdir": [
      "./dir3"
     ]
  }
}
```

filter result is:

```
├── dir1
│   ├── 1.php
│   └── dir11
│       └── 11.php
├── dir2
│   └── 2.php
└── dir3
    ├── 3.php
    ├── dir32
    │   └── 32.php
```

`31.php` `33.php` will be ignored during tag generation;

laravel example:
```json
{
  "filter": {
    "php-file-ext-list": [
      "php"
    ],
    "php-path-list": [
        "./app",
        "./database",
        "./vendor/laravel/framework/src/Illuminate"
    ],
    "php-path-list-without-subdir": []
  }
}
```

You can also add the standard php library with [phpstorm stubs][:phpstorm-stubs:].
Assuming you cloned this repo into `/usr/local/src/phpstorm-stubs` you base configuration will be:

```json
{
  "filter": {
    "php-file-ext-list": [
      "php"
    ],
    "php-path-list": [
        "/usr/local/src/phpstorm-stubs"
    ],
    "php-path-list-without-subdir": []
  }
}
```

### Rebuilding tags

If source has been changed, you may need run `ac-php-remake-tags` to remake tags.

ac-php internally uses [phpctags][:phpctags:], so its operability depends on the correct
syntax you use in the project. If something goes wrong with one of your files, you can find
all errors in the `*Messages*` buffer. For example:

```
phpctags[/home/jim/phptest/testa.php] ERROR:PHPParser: Unexpected token '}' on line 11 -
```

In this case you'll need to fix an error in `testa.php` and re run `ac-php-remake-tags`.


**Note:** You shouldn't download phpctags, ac-php already ships with its own modified version.


If you see something like this:

```
ac-php: Unable to resolve project root
```

This means you have to create the `.ac-php-conf.json` file in the project root:

``` sh
$ touch /path/to/the/project/.ac-php-conf.json
```

## FAQ

- **Q:** Something went wrong. It seems I followed all the instructions, but auto completion stopped working
- **A:** Run `M-x ac-php-remake-tags-all`

---

- **Q:** How I can create a reproducible test to create an issue?
- **A:** Please use [this issue][:issue-example:] as an example

## License

ac-php is open source software licensed under the GNU General Public Licence version 3 .

[:badge-ac-php:]: http://melpa.org/packages/ac-php-badge.svg
[:badge-ac-php-s:]: http://stable.melpa.org/packages/ac-php-badge.svg
[:badge-ac-php-core:]: http://melpa.org/packages/ac-php-core-badge.svg
[:badge-ac-php-core-s:]: http://stable.melpa.org/packages/ac-php-core-badge.svg
[:badge-company-php:]: https://melpa.org/packages/company-php-badge.svg
[:badge-company-php-s:]: http://stable.melpa.org/packages/company-php-badge.svg
[:badge-travis:]: https://travis-ci.com/xcwen/ac-php.svg
[:project-travis:]:https://travis-ci.com/xcwen/ac-php
[:project-ac-php:]: http://melpa.org/#/ac-php
[:project-ac-php-s:]: http://stable.melpa.org/#/ac-php
[:project-ac-php-core:]: http://melpa.org/#/ac-php-core
[:project-ac-php-core-s:]: http://stable.melpa.org/#/ac-php-core
[:project-company-php:]: https://melpa.org/#/company-php
[:project-company-php-s:]: http://stable.melpa.org/#/company-php
[:gh-ac:]: https://github.com/auto-complete/auto-complete
[:gh-company:]: https://github.com/company-mode/company-mode
[:gh-spacemacs:]: https://github.com/syl20bnr/spacemacs
[:gh-helm:]: https://github.com/emacs-helm/helm
[:gh-php-mode:]: https://github.com/emacs-php/php-mode
[:gh-yasnippet:]: https://github.com/joaotavora/yasnippet
[:melpa-gs:]: https://melpa.org/#/getting-started
[:phpstorm-stubs:]: https://github.com/JetBrains/phpstorm-stubs
[:issue-example:]: https://github.com/xcwen/ac-php/issues/51
[:phpctags:]: https://github.com/xcwen/phpctags
[:screenshots:]: https://github.com/xcwen/ac-php/tree/master/screenshots
[:elpa-dash:]: https://elpa.gnu.org/packages/dash.html
[:melpa-f:]: https://melpa.org/#/f
[:melpa-s:]: https://melpa.org/#/s
[:melpa-popup:]: https://melpa.org/#/popup
[:sf-cscope:]: http://cscope.sourceforge.net
