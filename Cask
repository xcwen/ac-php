;; -*- mode: emacs-lisp -*-

(source gnu)
(source melpa)

(package "ac-php" "2.0.7" "Auto Completion source for PHP.")

(files "*.el" "ac-php-comm-tags-data.json" "phpctags")

;; ac-php-core.el
(depends-on "json")
(depends-on "s" "1")
(depends-on "f" "0.17.0")
(depends-on "popup" "0.5.0")
(depends-on "cl")
(depends-on "dash" "1")
(depends-on "eldoc")
(depends-on "xcscope" "1")

;; ac-php.el
(depends-on "auto-complete" "1.4.0")
(depends-on "yasnippet" "0.8.0")

;; helm-ac-php-apropros.el
(depends-on "pcase")
(depends-on "helm")

;; company-php.el
(depends-on "cl-lib")
(depends-on "company")
(depends-on "company-template")

(development
 (depends-on "php-mode" "1")
 (depends-on "ert-x")
 (depends-on "ert-runner")
(depends-on "undercover"))
