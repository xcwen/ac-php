;;; ac-php-utils-test.el --- Utils tests -*- lexical-binding: t; -*-

;; Copyright (C) 2014-2019 jim <xcwenn@qq.com>
;; Copyright (C) 2019 Serghei Iakovlev <sadhooklay@gmail.com>

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

(ert-deftest ac-php-search/in-function-std-case ()
  :tags '(re search)
  (with-ac-php-file-test "in-function-std-case.php"
   (goto-char (point-max))
   (should (eq (ac-php--in-function-p) nil))
   (should (eq (ac-php--in-function-p (1- (point))) t))
   (should (eq (ac-php--in-function-p 1) nil))
   (should (eq (ac-php--in-function-p 24) t))
   (goto-char (point-min))
   (should (eq (ac-php--in-function-p 24) t))))

(ert-deftest ac-php-utils/class-list-preserves-inheritance-order ()
  (let ((class-map (make-hash-table :test #'equal))
        (inherit-map (make-hash-table :test #'equal)))
    (dolist (class-name '("\\A" "\\B" "\\C" "\\D"))
      (puthash class-name [] class-map))
    (puthash "\\A" ["\\B" "Missing" "\\C"] inherit-map)
    (puthash "\\B" ["\\D"] inherit-map)
    (should (equal (ac-php--get-check-class-list
                    "\\A" inherit-map class-map)
                   '("\\A" "\\B" "\\D" "\\C")))

    (puthash "\\A" ["\\B"] inherit-map)
    (puthash "\\B" ["\\A"] inherit-map)
    (should (equal (ac-php--get-check-class-list
                    "\\A" inherit-map class-map)
                   '("\\A" "\\B" "\\A")))))

(ert-deftest ac-php-utils/use-imports-remain-unique ()
  (with-ac-php-buffer-test
      "<?php\nuse Foo\\Bar;\nuse Foo\\Bar;\nuse Baz\\Qux as Alias;\nuse Baz\\Qux as Alias;\n"
    (should (equal (ac-php--get-all-use-as-name-in-cur-buffer)
                   '(("\\Baz\\Qux" "Alias")
                     ("\\Foo\\Bar" "Bar"))))))

(ert-deftest ac-php-utils/generated-tags-use-dynamic-container ()
  (let ((main-tags-file (make-temp-file "ac-php-main-tags-" nil ".el"))
        (vendor-tags-file (make-temp-file "ac-php-vendor-tags-" nil ".el"))
        (ac-php-tag-last-data-list nil)
        (g-ac-php-tmp-tags 'outside))
    (unwind-protect
        (progn
          (with-temp-file main-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"main.php\"]])"))
          (with-temp-file vendor-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"vendor.php\"]])"))
          (let ((tags-data (ac-php-load-data
                            main-tags-file vendor-tags-file "/project/")))
            (should (equal (append (ac-php-g--file-list tags-data) nil)
                           '("vendor.php" "main.php")))
            (should (equal (ac-php-g--project-root-dir tags-data) "/project/")))
          (should (eq g-ac-php-tmp-tags 'outside)))
      (delete-file main-tags-file)
      (delete-file vendor-tags-file))))

(provide 'ac-php-utils-test)
;;; ac-php-utils-test.el ends here
