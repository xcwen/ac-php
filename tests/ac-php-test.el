;;; ac-php-test.el --- Tests for ac-php

;; Copyright (C) 2013 Daniel Hackney
;;               2014, 2015 Eric James Michael Ritz

;; Author: Daniel Hackney <dan@haxney.org>
;; URL: https://github.com/ejmr/ac-php

;;; License

;; This file is free software; you can redistribute it and/or
;; modify it under the terms of the GNU General Public License
;; as published by the Free Software Foundation; either version 3
;; of the License, or (at your option) any later version.

;; This file is distributed in the hope that it will be useful,
;; but WITHOUT ANY WARRANTY; without even the implied warranty of
;; MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
;; GNU General Public License for more details.

;; You should have received a copy of the GNU General Public License
;; along with this file; if not, write to the Free Software
;; Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
;; 02110-1301, USA.

;;; Commentary:

;; Automate tests from the "tests" directory using `ert', which comes bundled
;; with Emacs >= 24.1.

;;; Code:
(require 'package)
(package-initialize)

(require 'f)

(setq load-path (append  (list (f-parent(f-parent load-file-name))) load-path ) )
;;(message "load-path %S" load-path )

(require 'ac-php)
(require 'ert)
(eval-when-compile
  (require 'cl))


(defvar ac-php-test-dir  (file-name-directory load-file-name)
  "Directory containing the `ac-php' test files.")

(defvar ac-php-test-valid-magics '(indent)
  "List of allowed \"magic\" directives which can appear in test cases.")

(defvar ac-php-test-magic-regexp "###ac-php-test### \\((.+)\\)"
"Regexp which identifies a magic comment.")

(defun ac-php-test-process-magics ()
  "Process the test directives in the current buffer.
These are the ###ac-php-test### comments. Valid magics are
listed in `ac-php-test-valid-magics'; no other directives will
be processed."
  (cl-flet ((indent (offset) (equal (current-indentation) offset)))
    (let (directives answers)
     (save-excursion
       (goto-char (point-min))
       (while (re-search-forward ac-php-test-magic-regexp nil t)
         (setq directives (read (buffer-substring (match-beginning 1)
                                                  (match-end 1))))
         (setq answers
               (append (mapcar (lambda (curr)
                                 (let ((fn (car curr))
                                       (args (mapcar 'eval (cdr-safe curr))))
                                   (if (memq fn ac-php-test-valid-magics)
                                       (apply fn args))))
                               directives)
                       answers))))
     answers)))

(defmacro* with-ac-php-test ((file &key style indent magic custom) &rest body)
  "Set up environment for testing `ac-php'.
Execute BODY in a temporary buffer containing the contents of
FILE, in `ac-php'. Optional keyword `:style' can be used to set
the coding style to one of the following:

1. `pear'
2. `drupal'
3. `wordpress'
4. `symfony2'
5. `psr2'

Using any other symbol for STYLE results in undefined behavior.
The test will use the PHP style by default.

If the `:custom' keyword is set, customized variables are not reset to
their default state prior to starting the test. Use this if the test should
run with specific customizations set."
  (declare (indent 1))
  `(with-temp-buffer
     (insert-file-contents (expand-file-name ,file ac-php-test-dir))
     (php-mode)
     (font-lock-fontify-buffer)
     ,(case style
        (pear '(php-enable-pear-coding-style))
        (drupal '(php-enable-drupal-coding-style))
        (wordpress '(php-enable-wordpress-coding-style))
        (symfony2 '(php-enable-symfony2-coding-style))
        (psr2 '(php-enable-psr2-coding-style))
        (t '(php-enable-default-coding-style)))

     ,(unless custom '(custom-set-variables '(php-lineup-cascaded-calls nil)))

     ,(if indent
          '(indent-region (point-min) (point-max)))
     ,(if magic
          '(should (reduce (lambda (l r) (and l r))
                           (ac-php-test-process-magics))))
     (goto-char (point-min))
     (let ((case-fold-search nil))
    ,@body)))

(ert-deftest ac-php-test-parse-line-1 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "  \t $this->func1()->s")
    (setq  ret '("this" "." "func1(" "." "s" ))
    (ac-php-test--parse-line line-txt ret  )
    ))

(defun ac-php-test--parse-line ( line-txt ret)
  (should (equal  (ac-php-remove-unnecessary-items-4-complete-method
                   (ac-php-split-line-4-complete-method line-txt ))
                  ret)))

(ert-deftest ac-php-test-parse-line-2 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt " this->asdfa ( \t (new class1( ))->run()->ss")
    (setq  ret '("class1(" "." "run(" "." "ss" ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-3 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt " $this->func")
    (setq  ret '("this" "." "func"  ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-4 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "this")
    (setq  ret '("this"  ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-5 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return this->sdfa&& this->ttt->ss")
    (setq  ret '("this" "." "ttt" "." "ss"  ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-6 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return this->sdfa ||  ClassT::getV")
    (setq  ret '("ClassT::" "." "getV"   ))
    (ac-php-test--parse-line line-txt ret  )
    ))



(ert-deftest ac-php-test-parse-line-7 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return (($this->tt())->kk())->ss ")
    (setq  ret '("this" "." "tt("   "." "kk(" "."  "ss"  ))
    (ac-php-test--parse-line line-txt ret  )
    ))


(ert-deftest ac-php-test-parse-line-8 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "\"sdfa\" => $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))





(ert-deftest ac-php-test-parse-line-10 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "$ss > $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-21 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "  } else  if ($role   == Erole:: ")
    (setq  ret '("Erole::" "."      ))
    (ac-php-test--parse-line line-txt ret  )
    ))

 

(ert-deftest ac-php-test-parse-line-11 ()
  (let (line-txt  ret )
    (setq line-txt "$ss <= $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-12 ()
  (let (line-txt  ret )
    (setq line-txt "$this->ss(0 <= $this->tt)->kk ")
    (setq  ret '("this" "." "ss(" "." "kk"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))


(ert-deftest ac-php-test-parse-line-13 ()
  (let (line-txt  ret )
    (setq line-txt "$this->ss? this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-14 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  tt ")
    (setq  ret '("tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-15 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  if (this->ss?this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))


(ert-deftest ac-php-test-parse-line-16 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  if (this->ss?this->tt:this->kk ")
    (setq  ret '("this" "." "kk"     ))
    (ac-php-test--parse-line line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-17 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  parent::ss")
    (setq  ret '( "parent::" "."  "ss"   ))
    (ac-php-test--parse-line line-txt ret  )
    ))
(ert-deftest ac-php-test-parse-line-18 ()
  (let (line-txt  ret )
    (setq line-txt "   \t $v >= $ff? \"sdfa\" : parent::ss . parent::xx")
    (setq  ret '("parent::"  "." "xx"  ))
    (ac-php-test--parse-line line-txt ret  )
    ))


(ert-deftest ac-php-test-parse-line-19 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "(yii\\web\\Application(config))->ru")
    (setq  ret '("yii\\web\\Application" "." "ru"   ))
    (ac-php-test--parse-line line-txt ret  )
    ))














;; (ert-deftest ac-php-test-issue-9 ()
;;   "Single quote in text in HTML misinterpreted.
;; The next character after \">We\" is a single quote. It should not
;; have a string face."
;;   :expected-result :failed
;;   (with-ac-php-test ("issue-9.php")
;;                       (search-forward ">We")
;;                       (forward-char) ;; Jump to after the opening apostrophe
;;     (should-not (eq
;;                  (get-text-property (point) 'face)
;;                  'font-lock-string-face))))

;; (ert-deftest ac-php-test-issue-14 ()
;;   "Array indentation."
;;   (with-ac-php-test ("issue-14.php" :indent t :magic t)))

;; (ert-deftest ac-php-test-issue-16 ()
;;   "Comma separated \"use\" (namespaces).
;; Gets the face of the text after the comma."
;;   (with-ac-php-test ("issue-16.php")
;;     (re-search-forward "^use " nil nil 3)
;;     (should (eq
;;              (get-text-property (search-forward ", ") 'face)
;;              'font-lock-type-face))))

;;; ac-php-test.el ends here

;; emacs --debug-init -Q --script ./php-mode-test.el 
;; End:

