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

* install [phpctags](https://github.com/xcwen/phpctags)
```bash
cd ~
git clone https://github.com/xcwen/phpctags.git
cd ~/phpctags/ && make 
sudo cp phpctags /usr/bin/ 
```

* mkdir ".tags"  in root of project

``` bash
cd /project/to/path #  root dir of project
mkdir .tags
```
* emacs php-mode function  define

```elisp
(add-hook 'php-mode-hook '(lambda ()
    (require 'auto-complete-php)
    (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
    (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
))
```

`ac-php-remake-tags` ;; **if source is changed ,re run this commond for update tags**

`ac-php-show-tip` ;; show define at point


* example：

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)

## Php extern for complete
define class memeber type ,function   return type

`public  $v1;`  => `public /*::classtype */ $v1;`

`public /*::Testa*/function get_v1()`  => ` public /*::classtype*/ function get_v1()`

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
        /*$value::Testa*/
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
