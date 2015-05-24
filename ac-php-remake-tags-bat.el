;; AT project root dir exec 
;; emacs -Q --script ~/.emacs.d/elpa/ac-php-*/ac-php-remake-tags-bat.el 
(require 'package)
(package-initialize)

(require 'ac-php)
(ac-php-remake-tags)
