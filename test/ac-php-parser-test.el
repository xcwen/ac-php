;;; ac-php-parser-test.el --- Parser test -*- lexical-binding: t; -*-

;; Copyright (C) 2014-2019 jim <xcwenn@qq.com>

;; Author: jim <xcwenn@qq.com>
;; Maintainer: jim
;; URL: https://github.com/xcwen/ac-php

;; This file is not part of GNU Emacs.

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

;; Automate tests from the "test" directory using `ert', which comes bundled
;; with Emacs >= 24.1.

;;; Code:

(ert-deftest ac-php-test-parse-line-2 ()
  (let (line-txt ret)
    (setq line-txt " this->asdfa ( \t (new class1( ))->run()->ss")
    (setq ret '("class1(" "." "run(" "." "ss"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-3 ()
  (let (line-txt ret)
    (setq line-txt " $this->func")
    (setq ret '("this" "." "func"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-4 ()
  (let (line-txt ret)
    (setq line-txt "this")
    (setq ret '("this"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-5 ()
  (let (line-txt ret)
    (setq line-txt "return this->sdfa&& this->ttt->ss")
    (setq ret '("this" "." "ttt" "." "ss"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-6 ()
  (let (line-txt ret)
    (setq line-txt "return this->sdfa ||  ClassT::getV")
    (setq ret '("ClassT::" "." "getV"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-7 ()
  (let (line-txt ret)
    (setq line-txt "return (($this->tt())->kk())->ss ")
    (setq ret '("this" "." "tt("   "." "kk(" "."  "ss" ))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-8 ()
  (let (line-txt ret)
    (setq line-txt "\"sdfa\" => $this->tt ")
    (setq ret '("this" "." "tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-10 ()
  (let (line-txt ret)
    (setq line-txt "$ss > $this->tt ")
    (setq ret '("this" "." "tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-21 ()
  (let (line-txt ret)
    (setq line-txt "  } else  if ($role   == Erole:: ")
    (setq ret '("Erole::" "."))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-11 ()
  (let (line-txt ret)
    (setq line-txt "$ss <= $this->tt ")
    (setq ret '("this" "." "tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-12 ()
  (let (line-txt ret)
    (setq line-txt "$this->ss(0 <= $this->tt)->kk ")
    (setq ret '("this" "." "ss(" "." "kk"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-13 ()
  (let (line-txt ret)
    (setq line-txt "$this->ss? this->tt ")
    (setq ret '("this" "." "tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-14 ()
  (let (line-txt ret)
    (setq line-txt "   \t  tt ")
    (setq ret '("tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-15 ()
  (let (line-txt ret)
    (setq line-txt "   \t  if (this->ss?this->tt ")
    (setq ret '("this" "." "tt"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-16 ()
  (let (line-txt ret)
    (setq line-txt "   \t  if (this->ss?this->tt:this->kk ")
    (setq ret '("this" "." "kk"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-17 ()
  (let (line-txt ret)
    (setq line-txt "   \t  parent::ss")
    (setq ret '( "parent::" "."  "ss"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-18 ()
  (let (line-txt ret)
    (setq line-txt "   \t $v >= $ff? \"sdfa\" : parent::ss . parent::xx")
    (setq ret '("parent::"  "." "xx"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-19 ()
  (let (line-txt ret)
    (setq line-txt "(yii\\web\\Application(config))->ru")
    (setq ret '("yii\\web\\Application(" "." "ru"))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-20 ()
  (let (line-txt ret)
    (setq line-txt ") );(new \\App\\Job\\Mindshow\\AiImageToCommonPic())->deal_one($ai_image_id)")
    (setq ret '("\\App\\Job\\Mindshow\\AiImageToCommonPic(" "." "deal_one("))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-parser/split-separator-uses-match-boundaries ()
  (should (equal
           (ac-php-split-string-with-separator
            "a  .  b" "[ \t]*\\.[ \t]*" "." t)
           '("a" "." "b"))))

(ert-deftest ac-php-parser/token-stack-does-not-read-input-as-elisp ()
  (should (equal
           (ac-php-remove-unnecessary-items-4-complete-method
            (ac-php-split-line-4-complete-method
             "$x->m(' say \" hi')->z"))
           '("x" "." "m(" "." "z"))))

(ert-deftest ac-php-parser/expression-scan-is-multiline-and-comment-aware ()
  (with-ac-php-buffer-test
      "<?php\n$service->first() // ignored->call()\n  ->second(\"// kept\")\n  ->third"
    (goto-char (point-max))
    (should (equal (ac-php--expression-before-point)
                   "$service->first()   ->second(\"// kept\")\n  ->third"))))

(ert-deftest ac-php-parser/expression-scan-honors-pos ()
  (with-ac-php-buffer-test
      "<?php\n$first->one();\n$second->two"
    (let ((first-expression-end
           (save-excursion
             (goto-char (point-min))
             (search-forward "one")
             (point))))
      (goto-char (point-max))
      (should (equal (ac-php--expression-before-point first-expression-end)
                     "$first->one")))))

(ert-deftest ac-php-parser/expression-scan-stops-at-point-min ()
  (with-ac-php-buffer-test "->deal"
    (goto-char (point-max))
    (should (equal (ac-php--expression-before-point) "->deal"))))

(ert-deftest ac-php-parser/expression-scan-does-not-parse-every-character ()
  (with-ac-php-buffer-test
      (concat "<?php\n$service"
              (mapconcat (lambda (_) "->method()")
                         (number-sequence 1 1000) "")
              "->tail")
    (goto-char (point-max))
    (let ((original-syntax-ppss (symbol-function 'syntax-ppss))
          (syntax-ppss-calls 0))
      (cl-letf (((symbol-function 'syntax-ppss)
                 (lambda (&rest args)
                   (setq syntax-ppss-calls (1+ syntax-ppss-calls))
                   (apply original-syntax-ppss args))))
        (should (string-suffix-p
                 "->method()->tail"
                 (ac-php--expression-before-point)))
        (should (< syntax-ppss-calls 10))))))

(ert-deftest ac-php-parser/expression-scan-skips-prior-statements ()
  (with-ac-php-buffer-test
      (concat "<?php\nfunction run() {\n"
              (mapconcat (lambda (index)
                           (format "$v%d = %d;" index index))
                         (number-sequence 1 2000) "\n")
              "\n$service->tail")
    (goto-char (point-max))
    (let ((original-syntax-ppss (symbol-function 'syntax-ppss))
          (syntax-ppss-calls 0))
      (cl-letf (((symbol-function 'syntax-ppss)
                 (lambda (&rest args)
                   (setq syntax-ppss-calls (1+ syntax-ppss-calls))
                   (apply original-syntax-ppss args))))
        (should (equal (ac-php--expression-before-point)
                       "$service->tail"))
        (should (< syntax-ppss-calls 10))))))

(ert-deftest ac-php-parser/expression-scan-skips-comment-markers-in-strings ()
  (with-ac-php-buffer-test
      (concat "<?php\n$service->method(\""
              (mapconcat (lambda (_) "http://host/#part")
                         (number-sequence 1 1000) "")
              "\")->tail")
    (goto-char (point-max))
    (let ((original-syntax-ppss (symbol-function 'syntax-ppss))
          (syntax-ppss-calls 0))
      (cl-letf (((symbol-function 'syntax-ppss)
                 (lambda (&rest args)
                   (setq syntax-ppss-calls (1+ syntax-ppss-calls))
                   (apply original-syntax-ppss args))))
        (should (string-suffix-p
                 "\")->tail" (ac-php--expression-before-point)))
        (should (< syntax-ppss-calls 10))))))

(ert-deftest ac-php-parser/callable-normalization-is-linear-search ()
  (should (equal (ac-php--normalize-callable
                  "prefix array($foo, 'run') suffix")
                 "$foo->run"))
  (should (equal (ac-php--normalize-callable
                  "prefix [$foo, \"run\"] suffix")
                 "$foo->run"))
  (should (equal (ac-php--normalize-callable "plain text")
                 "plain text")))

(ert-deftest ac-php-parser/callable-expression-keeps-containing-delimiters ()
  (dolist (fixture '("<?php\n[$foo, \"run\""
                     "<?php\narray($foo, \"run\""))
    (with-ac-php-buffer-test fixture
      (goto-char (point-max))
      (let ((expression (ac-php--expression-before-point)))
        (should (equal (ac-php--normalize-callable expression)
                       "$foo->run"))))))

(provide 'ac-php-parser-test)
;;; ac-php-parser-test.el ends here
