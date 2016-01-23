# ac-php   [![MELPA](http://melpa.org/packages/ac-php-badge.svg)](http://melpa.org/#/ac-php)     [![MELPA Stable](http://stable.melpa.org/packages/ac-php-badge.svg)](http://stable.melpa.org/#/ac-php)

emacs auto-complete for php

support  `auto-complete`  and `company-mode`

use [phpctags](https://github.com/xcwen/phpctags) gen tags 

and use `ac-php`  work with tags 


* support system function 

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/7.png)
------
![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/8.png)

* support system class

core: SPL SplFileInfo DOMDocument  SimpleXMLElement   ... 

externed: PDO Http mysqli Imagick  SQLite3 Memcache  ...

externed:  Redis ,Swoole 

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/6.png)

* support user self class system


![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/4.png)


* example:

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)


 
## Table of Contents

* [Install](#install)
* [Test](#test)
* [Usage](#usage)
* [Usage Company](#usage-company)
* [php extern for complete](#php-doc-for-complete)
* [tags](#tags)
* [large php project config](#configue-php-file-search-for-large-project)
* [disable cscope config](#disable-cscope-config)
* [FQA](#fqa)


##  Install 
### UBUNTU
* install `php5-cli` command  for phpctags
```bash 
localhost:~/$ sudo apt-get install php5-cli 
```

* install `cscope` command  for `ac-php-cscope-find-egrep-pattern`
```bash 
localhost:~/$ sudo apt-get install cscope
```

### MAC OSX 
```bash
 brew  install homebrew/php/php56
```
```bash
 brew  install cscope 
```
### check `php`,`cscope`  existed 
```bash
localhost:~$ php --version
PHP 5.5.20 (cli) (built: Feb 25 2015 23:30:53) 
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
localhost:~$ cscope --version
cscope: version 15.8a
```


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
               (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
               (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
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

"M-x" :`package-list-packages`  find  `ac-php` install

* emacs php-mode function  define

work for auto-complete-mode  , **Company-mode config  at [here](#usage-company)**

```elisp
  (add-hook 'php-mode-hook
            '(lambda ()
               (auto-complete-mode t)
               (require 'ac-php)
               (setq ac-sources  '(ac-source-php ) )
               (yas-global-mode 1)
               (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
               (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
               ))
```




* create file ".ac-php-conf.json"  in root of project

``` bash
cd /project/to/path #  root dir of project
touch .ac-php-conf.json 
```

* DONE 

*  command 

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
<td class="org-left"> if source is changed ,re run this commond for update tags </td>
</tr>

<tr>
<td class="org-left"> ac-php-remake-tags-all</td>
<td class="org-left"> **if you find a error, run it an retest**</td>
</tr>

<tr>
<td class="org-left"> ac-php-find-symbol-at-point</td>
<td class="org-left"> goto define </td>
</tr>

<tr>
<td class="org-left"> ac-php-location-stack-back</td>
<td class="org-left"> go back </td>
</tr>

<tr>
<td class="org-left"> ac-php-show-tip </td>
<td class="org-left"> show define at point </td>
</tr>

<tr>
<td class="org-left"> ac-php-cscope-find-egrep-pattern </td>
<td class="org-left"> find current-word in project
 <br/>
</td>
</tr>

</tbody>
</table>




## Usage Company
```elisp
(add-hook 'php-mode-hook
          '(lambda ()
             (require 'ac-php-company)
             (company-mode t)
             (add-to-list 'company-backends 'company-ac-php-backend )))
```
use  `M-x: company-complete` for complete

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/company-1.png)


## Php Doc for complete  
define class memeber type :

`public  $v1;`  =>
``` php
/**
 * @var classtype
 */
public $v1;
```

if you won't define `public $v1 ` you can define with comment ,like this =>
```
/** @var  $v1 \Test\Testa  */
```
![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/5.png)


define class function   return type:

`public  function get_v1()`  =>
```php
/**
 * @return classtype 
 */
public function get_v1()

```

or define use php7 :

```php
public function get_v1() :classtype  {

}
```

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/2.png)

![](https://raw.githubusercontent.com/xcwen/ac-php/master/images/3.png)


define variable: (**if function or member no define reutrn value  you need define it  **)

`$value=ff();` => 
```php
/** @var $value  Testa */
$value=ff();
```

like this
```php
class Testa {
    /** @var  $v8 \Test\Testa  */

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

        //for complete memeber 
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
tags file location dir is in  `~/.ac-php/project_dir`   for example:  `~/.ac-php/tags-home-jim-ac-php-phptest/`

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



### Configue PHP file Search for Large Project

config file name  is `.ac-php-conf.json`

when run `ac-php-remake-tags`  will `.ac-php-conf.json` set default json config when  it's empty 

like this

```json
{
  "use-cscope" : true,
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


`php-file-ext-list` : file extern name list;

`php-path-list`:  find php files *recursion*  ;

`php-path-list-without-subdir`:  find php files  *no recursion* no find php from subdir  ;

for exmaple:

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

`31.php` `33.php` will not gen tags;

### Disable Cscope Config
set `use-cscope:  false`  in `.ac-php-conf.json`


### Rebuild Tags 
**if source is changed ,re run this commond for update tags**: `ac-php-remake-tags` 

if php file cannot pass from `phpctags`.

you can find any  error from `Messages` buffer  fix it and next

like this 
```
phpctags[/home/jim/phptest/testa.php] ERROR:PHPParser: Unexpected token '}' on line 11 - 
```
you need fix testa.php  error and re run `ac-php-remake-tags`


if show:
```
no find  file .ac-php-conf.json dir in path list :/home/jim/phptest/ 
```

you need *create file ".ac-php-conf.json" in root of project*

like this:

`touch /home/jim/phptest/.ac-php-conf.json`

or

`touch /home/jim/.ac-php-conf.json`



## FQA 
#  for all any question　

you find a question 

exec : `M-x`: `ac-php-remake-tags-all`

and retest




