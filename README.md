# ac-php
emacs auto-complete for php

## Table of Contents

* [Usage](#usage)

## Usage
* install require package
install `auto-complete-mode`, `php-mode` form elpa package  

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

```
    ( define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
    ( define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back


```

ac-php-remake-tags ;; if source is changed ,rerun this commond

ac-php-show-tip ;; show define


* example：

![example.gif](https://raw.githubusercontent.com/xcwen/ac-php/master/images/ac-php.gif)

