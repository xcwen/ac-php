;; AT project root dir exec 
;; emacs -Q --script ~/.emacs.d/elpa/ac-php-*/ac-php-remake-tags-without-cscope-bat.el 
(require 'package)
(package-initialize)
(setq load-path (append  load-path  (list (file-name-directory load-file-name)) ))
(require 'ac-php)
(setq ac-php-cscope nil)
(ac-php-remake-tags)


