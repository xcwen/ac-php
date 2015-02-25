# ac-php
emacs auto-complete for php


use [phpctags](https://github.com/xcwen/phpctags) gen tags 

and use `ac-php`  work with tags 

 
## Table of Contents


* [Usage](#usage)
* [php extern for complete](#php-extern-for-complete)
* [rebuild tags](#rebuild-tags)
* [FQA](#fqa)


## Usage



* install require package
install `auto-complete-mode`, `php-mode`  form [elpa package](https://github.com/milkypostman/melpa)

install `php5-cli` command  for phpctags
```bash
localhost:~/$ sudo apt-get install php5-cli 
localhost:~/$ php --version
PHP 5.5.9-1ubuntu4.6 (cli) (built: Feb 13 2015 19:17:11) 
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
```


* mkdir ".tags"  in root of project

``` bash
cd /project/to/path #  root dir of project
mkdir .tags
```
* emacs php-mode function  define

```elisp
(add-hook 'php-mode-hook '(lambda ()
							(auto-complete-mode t)
							(setq ac-sources  '(ac-source-php ) )
							(require 'ac-php)
							(define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
							(define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
							))
```

`ac-php-remake-tags` ;; **if source is changed ,re run this commond for update tags**

`ac-php-show-tip` ;; show define at point


* example：

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)

## Php extern for complete
define class memeber type :

`public  $v1;`  => `public /*::classtype */ $v1;`

define class function   return type:

`public  function get_v1()`  => ` public /*::classtype*/ function get_v1()`

define variable: 

`$value=new xxx();` => 
```php
/*$value::classtype*/
$value=new Testa();
```

like this
```php
class Testa {
	public /*::Testb */ $v1;
	public /*::Testb */ $v2;
    public function set_v1($v){
        $v=trim($v);
        //define value type
        /*$v::Testa*/
        $v=new Testb();
        $this->v1=$v;
    }
    public /*::Testa*/function get_v1(){
        $this->get_v1("ss");
    }
}
```


## Rebuild Tags
tags file location dir is in  `.tags`   for example:  `/project/to/path/.tags`
```bash
localhost:~/phptest/.tags$ tree .
.
├── tags-data.el
└── tags_dir_jim
    ├── a.tags
    ├── testa.tags
    └── testb.tags
1 directory, 4 files
```



**if source is changed ,re run this commond for update tags**: `ac-php-remake-tags` 

if php file cannot pass from `phpctags`.

you can find any  error from `Messages` buffer  fix it and next

like this 
```
phpctags[/home/jim/phptest/testa.php] ERROR:PHPParser: Unexpected token '}' on line 11 - 
```
you need fix testa.php  error and re run `ac-php-remake-tags`



## FQA
