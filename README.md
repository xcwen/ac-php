# ac-php   [![MELPA](http://melpa.org/packages/ac-php-badge.svg)](http://melpa.org/#/ac-php)     [![MELPA Stable](http://stable.melpa.org/packages/ac-php-badge.svg)](http://stable.melpa.org/#/ac-php)
# ac-php-core   [![MELPA](http://melpa.org/packages/ac-php-core-badge.svg)](http://melpa.org/#/ac-php-core)     

emacs auto-completion for php

supports  `auto-complete`  and `company-mode`  and `spacemacs layer`

use [phpctags](https://github.com/xcwen/phpctags) to generate tags

and use `ac-php`  to work with these tags


* supports system functions

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/7.png)
------
![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/8.png)

* supports system classes

core: SPL SplFileInfo DOMDocument  SimpleXMLElement   ...

extended: PDO Http mysqli Imagick  SQLite3 Memcache  ...

extended:  Redis, Swoole

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/6.png)

* supports user's own classes


![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/4.png)


* example:

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)



![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/chain-call.png)


## Table of Contents

* [Install](#install)
* [Test](#test)
* [Usage](#usage)
* [Usage with Company](#usage-company)
* [Usage with spacemacs](#usage-spacemacs)
* [php extern for complete](#php-doc-for-complete)
* [tags](#tags)
* [large php project config](#configue-php-file-search-for-large-project)
* [FAQ](#faq)


##  Install
### UBUNTU
* install `php-cli` package for phpctags
```bash
localhost:~/$ sudo apt-get install php-cli
```


### MAC OSX
```bash
 brew install homebrew/php/php56
```

### check if `php`  exists
```bash
localhost:~$ php --version
PHP 5.5.20 (cli) (built: Feb 25 2015 23:30:53)
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies


##  Test


```bash
#backup old .emacs
cp ~/.emacs ~/.emacs.bak
```

save it as `~/.emacs`
```elisp
  (setq package-archives
        '(("melpa" . "https://melpa.org/packages/")) )
  (package-initialize)
  (unless (package-installed-p 'ac-php )
    (package-refresh-contents)
    (package-install 'ac-php )
    )
  (require 'cl)
  (require 'php-mode)
  (add-hook 'php-mode-hook
            '(lambda ()
               (auto-complete-mode t)
               (require 'ac-php)
               (setq ac-sources  '(ac-source-php ) )
               (yas-global-mode 1)
               (ac-php-core-eldoc-setup ) ;; enable eldoc

               (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
               (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back)    ;go back
               ))
```

```bash
cd ~/
git clone https://github.com/xcwen/ac-php/
#test php files in ~/ac-php/phptest
#open file for test
emacs ~/ac-php/phptest/testb.php
```

# Usage

* install `ac-php` from melpa
```elisp
  (setq package-archives
        '(("melpa" . "https://melpa.org/packages/")) )
```

"M-x": `package-list-packages` find `ac-php` there and install it

* emacs php-mode function define

works for auto-complete-mode, **company-mode config is available [here](#usage-company)**

```elisp
  (add-hook 'php-mode-hook
            '(lambda ()
               (auto-complete-mode t)
               (require 'ac-php)
               (setq ac-sources  '(ac-source-php ) )
               (yas-global-mode 1)

               (ac-php-core-eldoc-setup ) ;; enable eldoc
               (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
               (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back)    ;go back
               ))
```




* create file ".ac-php-conf.json" in root of your project

``` bash
cd /project/to/path #  root dir of project
touch .ac-php-conf.json
```

* DONE

*  commands

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="org-left" />

<col  class="org-left" />
</colgroup>
<thead>
<tr>
<th scope="col" class="org-left">cmd</th>
<th scope="col" class="org-left">info</th>
</tr>
</thead>

<tbody>
<tr>
<td class="org-left"> ac-php-remake-tags</td>
<td class="org-left"> if source has been changed, run this command to update tags </td>
</tr>

<tr>
<td class="org-left"> ac-php-remake-tags-all</td>
<td class="org-left"> **if you find an error, run it and retest**</td>
</tr>

<tr>
<td class="org-left"> ac-php-find-symbol-at-point</td>
<td class="org-left"> go to definition </td>
</tr>

<tr>
<td class="org-left"> ac-php-location-stack-back</td>
<td class="org-left"> go back </td>
</tr>

<tr>
<td class="org-left"> ac-php-show-tip </td>
<td class="org-left"> show definition at point </td>
</tr>

<tr>
<td class="org-left"> helm-ac-php-apropos </td>
<td class="org-left"> search through all the definitions of a project with <a href="https://github.com/emacs-helm/helm">helm</a> </td>
</tr>

</tbody>
</table>




## Usage with Company

"M-x": `package-list-packages`  find  `company-php` install

```elisp
(add-hook 'php-mode-hook
          '(lambda ()
             (require 'company-php)
             (company-mode t)
             (ac-php-core-eldoc-setup) ;; enable eldoc
             (make-local-variable 'company-backends)
             (add-to-list 'company-backends 'company-ac-php-backend)))
```
use  `M-x: company-complete` to complete

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/company-1.png)


## Usage with Spacemacs

   https://github.com/syl20bnr/spacemacs/tree/develop/layers/%2Blang/php


## Php Doc completion
define class member type:

`public  $v1;`  =>
``` php
/**
 * @var classtype
 */
public $v1;
```

if you won't define `public $v1` you can define it in a class comment, like this =>
```php
/**
  * @property  \Test\Testa  $v1
  * @method  int add($a,$b)
  * @use  \Test\TestC
 */
class Testb  extends Ta {
...
}
```

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/5.png)


define function's return type using a doc comment:

```php
/**
 * @return classtype
 */
public function get_v1()

```

```php
/**
  * @method  classtype get_v1()
 */
class Testb  extends Ta {
...
}
```

or define it using php7 typehints:

```php
public function get_v1(): classtype  {

}

```
![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/2.png)

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/3.png)


define variable: (**if function or member has no defined return value then you need to define it**)

`$value=ff();` =>
```php
/** @var  Testa $value */
$value=ff();
```

like this
```php
/**
   class define ..
   @property  \Test\Testa  $v8
 */
class Testa {

    /**
     * @var int;
     */
    const CON=1;


    /**
     * @var Testb;
     */
    public  $v1;
    /**
     * @var \Test\TestC;
     */
    public  $v2;
    public function set_v1($v){

        //for complete system function
        $v=trim($v);

        $c=new Testb();
        //can complete
        $c->get_v2();

        //for complete member
        $this->v1=$v;


        //for complete function  return type
        $this-> get_v2()->testC();

        //for complete field from comment
        $this->v8->testA();

        //for complete system class
        $q=new SplQueue ();
        $q->push(11);

       //jump for class function point
        $f=array($this->v8, "test_A" );
        $f();

    }

    /**
     *
     * @return  \Test\TestC;
     */
    public function get_v2(){
        $this->v2;
    }
}
```
![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/1.png)


## Tags
tags file location dir is in  `~/.ac-php/project_dir`, for example:  `~/.ac-php/tags-home-jim-ac-php-phptest/`

```bash
localhost:~/.ac-php$ tree tags-home-jim-ac-php-phptest/
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



### Configure PHP file searching for a large project

configuration file name  is `.ac-php-conf.json`

when you run `ac-php-remake-tags`  and your `.ac-php-conf.json` is empty, default json will be generated

which looks like this

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


`php-file-ext-list`: file extern name list;

`php-path-list`:  paths to search for php files *recursively*;

`php-path-list-without-subdir`:  paths to search for php files *excluding subdirs*;

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

You can also add the standard php library with [phpstorm stubs](https://github.com/JetBrains/phpstorm-stubs).

Assuming you cloned this repo into <code>/usr/local/src/phpstorm-stubs</code> you base configuration will be:

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


### Rebuild Tags
**if source is changed, re run this command to update tags**: `ac-php-remake-tags`

If something goes wrong with one of your files, you can find all errors in the `Messages` buffer.  
Fix it and get to the next error.

like this:
```
phpctags[/home/jim/phptest/testa.php] ERROR:PHPParser: Unexpected token '}' on line 11 -
```
you need to fix an error in testa.php and re run `ac-php-remake-tags`


if it shows:
```
no find file .ac-php-conf.json dir in path list :/home/jim/phptest/
```

then you need to *create file ".ac-php-conf.json" in root of project*

like this:

`touch /home/jim/phptest/.ac-php-conf.json`

or

`touch /home/jim/.ac-php-conf.json`



## FAQ
#  To approach a problem　

If you want to tackle down a problem, you should

exec: `M-x`: `ac-php-remake-tags-all`

and retest

# for `test code` example
[ issue example](https://github.com/xcwen/ac-php/issues/51)

```elisp
;;; Usage: /path/to/emacs -nw -Q -l /path/to/test-ac-php.el

(toggle-debug-on-error)

(global-set-key (kbd "C-h") 'delete-backward-char)
(global-set-key (kbd "M-h") 'backward-kill-word)
(global-set-key (kbd "<f1>") 'help-command)
(define-key isearch-mode-map "\C-h" 'isearch-delete-char)

(setq package-user-dir (format "%s/elpa--test-ac-php" user-emacs-directory))
(setq package-archives
      ;;'(("melpa" . "http://mirrors.tuna.tsinghua.edu.cn/elpa/melpa/")))
       '(("melpa" . "https://melpa.org/packages/")))

(package-initialize)

(defmacro try-install (pkg)
  `(unless (package-installed-p ,pkg)
     (package-refresh-contents)
     (package-install ,pkg)))

(try-install 'ac-php)
(try-install 'company)
(try-install 'company-php)

(require 'cl)
(require 'php-mode)

(add-hook 'php-mode-hook
          '(lambda ()
             (require 'company-php)
             (company-mode t)
             (ac-php-core-eldoc-setup ) ;; enable eldoc
             (add-to-list 'company-backends 'company-ac-php-backend)))

(setq auto-mode-alist
      (append
       '(("\\.php" . php-mode)) auto-mode-alist))

(add-hook 'after-init-hook 'global-company-mode)
(run-hooks 'after-init-hook)

;;; test-ac-php.el ends here

```

