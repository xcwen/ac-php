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
                   '("\\A" "\\B")))))

(ert-deftest ac-php-utils/class-list-visits-diamond-once ()
  (let ((class-map (make-hash-table :test #'equal))
        (inherit-map (make-hash-table :test #'equal)))
    (dolist (class-name '("\\A" "\\B" "\\C" "\\D"))
      (puthash class-name [] class-map))
    (puthash "\\A" ["\\B" "\\C"] inherit-map)
    (puthash "\\B" ["\\D"] inherit-map)
    (puthash "\\C" ["\\D"] inherit-map)
    (puthash "\\D" ["\\A"] inherit-map)
    (should (equal (ac-php--get-check-class-list
                    "\\A" inherit-map class-map)
                   '("\\A" "\\B" "\\C" "\\D")))))

(ert-deftest ac-php-utils/diamond-prefers-descendant-member ()
  (let* ((class-map (make-hash-table :test #'equal))
         (inherit-map (make-hash-table :test #'equal))
         (child-member ["m" "run(" "" "child.php:1" "child"
                        "\\C" "public" ""])
         (ancestor-member ["m" "run(" "" "ancestor.php:1" "ancestor"
                           "\\D" "public" ""])
         (tags-data (list class-map (make-hash-table :test #'equal)
                          inherit-map [] "/project/")))
    (puthash "\\A" [] class-map)
    (puthash "\\B" [] class-map)
    (puthash "\\C" (vector child-member) class-map)
    (puthash "\\D" (vector ancestor-member) class-map)
    (puthash "\\A" ["\\B" "\\C"] inherit-map)
    (puthash "\\B" ["\\D"] inherit-map)
    (puthash "\\C" ["\\D"] inherit-map)
    (let ((members
           (ac-php-get-class-member-list
            class-map inherit-map "\\A" tags-data)))
      (should (memq child-member members))
      (should-not (memq ancestor-member members)))
    (should
     (eq child-member
         (ac-php-get-class-member-info
          class-map inherit-map "\\A" "run(" tags-data)))))

(ert-deftest ac-php-utils/class-list-growth-follows-unique-classes ()
  (let ((class-map (make-hash-table :test #'equal))
        (inherit-map (make-hash-table :test #'equal))
        (depth 12))
    (dotimes (index depth)
      (let ((root (format "\\Root%d" index))
            (left (format "\\Left%d" index))
            (right (format "\\Right%d" index))
            (next-root (format "\\Root%d" (1+ index))))
        (dolist (class-name (list root left right next-root))
          (puthash class-name [] class-map))
        (puthash root (vector left right) inherit-map)
        (puthash left (vector next-root) inherit-map)
        (puthash right (vector next-root) inherit-map)))
    (let ((class-order
           (ac-php--get-check-class-list
            "\\Root0" inherit-map class-map)))
      (should (= (length class-order) (1+ (* depth 3))))
      (should (= (length class-order)
                 (length (delete-dups (copy-sequence class-order))))))))

(ert-deftest ac-php-utils/class-members-use-kind-aware-overrides ()
  (let* ((class-map (make-hash-table :test #'equal))
         (inherit-map (make-hash-table :test #'equal))
         (child-method ["m" "Run(" "" "child.php:1" "child-method"
                        "\\Child" "public" ""])
         (child-property ["p" "Status" "" "child.php:2" "child-property"
                          "\\Child" "public" ""])
         (child-case ["p" "Case" "" "child.php:3" "child-case"
                      "\\Child" "public" ""])
         (child-shared-property
          ["p" "shared" "" "child.php:4" "child-shared-property"
           "\\Child" "public" ""])
         (child-shared-method
          ["m" "shared(" "" "child.php:5" "child-shared-method"
           "\\Child" "public" ""])
         (parent-method ["m" "run(" "" "parent.php:1" "parent-method"
                         "\\Parent" "public" ""])
         (parent-property ["p" "Status" "" "parent.php:2" "parent-property"
                           "\\Parent" "public" ""])
         (parent-case ["p" "case" "" "parent.php:3" "parent-case"
                       "\\Parent" "public" ""])
         (parent-shared-property
          ["p" "shared" "" "parent.php:4" "parent-shared-property"
           "\\Parent" "public" ""])
         (parent-shared-method
          ["m" "SHARED(" "" "parent.php:5" "parent-shared-method"
           "\\Parent" "public" ""])
         (tags-data (list class-map (make-hash-table :test #'equal)
                          inherit-map [] "/project/")))
    (puthash "\\Child"
             (vector child-method child-property child-case
                     child-shared-property child-shared-method)
             class-map)
    (puthash "\\Parent"
             (vector parent-method parent-property parent-case
                     parent-shared-property parent-shared-method)
             class-map)
    (puthash "\\Child" ["\\Parent"] inherit-map)
    (let ((members
           (ac-php-get-class-member-list
            class-map inherit-map "\\Child" tags-data)))
      (should (memq child-method members))
      (should-not (memq parent-method members))
      (should (memq child-property members))
      (should-not (memq parent-property members))
      (should (memq child-case members))
      (should (memq parent-case members))
      (should (memq child-shared-property members))
      (should (memq child-shared-method members))
      (should-not (memq parent-shared-property members))
      (should-not (memq parent-shared-method members))
      ;; The generation-scoped flattened result is reused as-is.
      (should
       (eq members
           (ac-php-get-class-member-list
            class-map inherit-map "\\Child" tags-data))))
    (should
     (eq child-method
         (ac-php-get-class-member-info
          class-map inherit-map "\\Child" "RUN(" tags-data)))
    (should
     (eq child-property
         (ac-php-get-class-member-info
          class-map inherit-map "\\Child" "Status" tags-data)))
    (should
     (eq parent-case
         (ac-php-get-class-member-info
          class-map inherit-map "\\Child" "case" tags-data)))
    (cl-letf (((symbol-function 'ac-php-get-class-name-by-key-list)
               (lambda (&rest _args) "\\Child")))
      (let* ((candidates (ac-php-candidate-class tags-data "\\Child."))
             (candidate-names (mapcar #'substring-no-properties candidates))
             (shared-method
              (cl-find "shared(" candidates :test #'string=)))
        (should (member "shared" candidate-names))
        (should shared-method)
        (should (equal (get-text-property
                        0 'ac-php-return-type shared-method)
                       "child-shared-method"))))))

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
            (should (equal (ac-php-g--project-root-dir tags-data) "/project/"))
            (should (hash-table-p ac-php-tag-last-data-list))
            (should (= (hash-table-count ac-php-tag-last-data-list) 2)))
          (should (eq g-ac-php-tmp-tags 'outside)))
      (delete-file main-tags-file)
      (delete-file vendor-tags-file))))

(ert-deftest ac-php-utils/tags-cache-reloads-without-growing ()
  (let ((main-tags-file (make-temp-file "ac-php-main-tags-" nil ".el"))
        (vendor-tags-file (make-temp-file "ac-php-vendor-tags-" nil ".el"))
        (ac-php-tag-last-data-list nil))
    (unwind-protect
        (progn
          (with-temp-file vendor-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"vendor.php\"]])"))
          (dotimes (index 4)
            (with-temp-file main-tags-file
              (insert (format
                       "(setq g-ac-php-tmp-tags [nil nil nil [\"main-%d.php\"]])"
                       index)))
            ;; Use a newly allocated but equal path on every call.  The old
            ;; `assq-delete-all' cache leaked one entry for each such reload.
            (let ((tags-data
                   (ac-php-load-data (copy-sequence main-tags-file)
                                     (copy-sequence vendor-tags-file)
                                     "/project/")))
              (should (equal (append (ac-php-g--file-list tags-data) nil)
                             (list "vendor.php"
                                   (format "main-%d.php" index))))
              (should (= (hash-table-count ac-php-tag-last-data-list) 2)))))
      (delete-file main-tags-file)
      (delete-file vendor-tags-file))))

(ert-deftest ac-php-utils/tags-cache-invalidates-when-vendor-changes ()
  (let ((main-tags-file (make-temp-file "ac-php-main-tags-" nil ".el"))
        (vendor-tags-file (make-temp-file "ac-php-vendor-tags-" nil ".el"))
        (ac-php-tag-last-data-list (make-hash-table :test #'equal)))
    (unwind-protect
        (progn
          (with-temp-file main-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"main.php\"]])"))
          (with-temp-file vendor-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"vendor-v1.php\"]])"))
          (should
           (equal
            (append
             (ac-php-g--file-list
              (ac-php-load-data main-tags-file vendor-tags-file "/project/"))
             nil)
            '("vendor-v1.php" "main.php")))

          ;; Main tags stay untouched; changing only vendor tags must rebuild
          ;; both the vendor entry and the main entry that contains its data.
          (with-temp-file vendor-tags-file
            (insert "(setq g-ac-php-tmp-tags [nil nil nil [\"vendor-v2.php\"]])"))
          (should
           (equal
            (append
             (ac-php-g--file-list
              (ac-php-load-data main-tags-file vendor-tags-file "/project/"))
             nil)
            '("vendor-v2.php" "main.php")))
          (should (= (hash-table-count ac-php-tag-last-data-list) 2)))
      (delete-file main-tags-file)
      (delete-file vendor-tags-file))))

(provide 'ac-php-utils-test)
;;; ac-php-utils-test.el ends here
