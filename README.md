# ac-php
emacs auto-complete for php


use [phpctags](https://github.com/vim-php/phpctags) gen tags 

and use `ac-php`  work with tags 

 
## Table of Contents


* [Usage](#usage)


## Usage



* install require package
install `auto-complete-mode`, `php-mode`  form elpa package

* install phpctags 
```
cd ~
git clone https://github.com/vim-php/phpctags.git
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

`ac-php-remake-tags` ;; if source is changed ,re run this commond for update tags
`ac-php-show-tip` ;; show define at point


* example：

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)

