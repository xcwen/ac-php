;;; ac-php-extension-test.el --- Extra completion API tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise project-specific completion providers across every frontend.

;;; Code:

(defun ac-php-test--extra-provider (tags-data)
  "Return fixture completion using TAGS-DATA when candidates are requested."
  (let ((result (list :prefix "db.us")))
    (when tags-data
      (setq result
            (plist-put
             result :candidates
             (list (propertize
                    "db.user_id"
                    'ac-php-help "int"
                    'ac-php-return-type "int"
                    'ac-php-tag-type "p")))))
    result))

(ert-deftest ac-php-extension/core-uses-extra-candidates ()
  (with-ac-php-buffer-test "<?php\nfoo(\"db.us|CURSOR|\");"
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((ac-php-extra-completion-functions
           '(ac-php-test--extra-provider))
          (tags (list (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      [] "/project/")))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (let ((candidate (car (ac-php-candidate))))
          (should (equal candidate "db.user_id"))
          (should (equal (get-text-property 0 'ac-php-return-type candidate)
                         "int")))))))

(ert-deftest ac-php-extension/frontends-use-extra-prefix ()
  (with-ac-php-buffer-test "<?php\nfoo(\"db.us|CURSOR|\");"
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((ac-php-extra-completion-functions
           '(ac-php-test--extra-provider)))
      (should (equal (company-ac-php--prefix) '("db.us" . t)))
      (should (= (ac-php-prefix) (- (point) 5))))))

(ert-deftest ac-php-extension/company-filters-with-extra-prefix ()
  (with-ac-php-buffer-test "<?php\nfoo(\"db.us|CURSOR|\");"
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((ac-php-extra-completion-functions
           '(ac-php-test--extra-provider))
          (tags (list (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      [] "/project/")))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (should
         (equal (mapcar #'substring-no-properties
                        (company-ac-php-candidate "ignored"))
                '("db.user_id")))))))

(ert-deftest ac-php-extension/nil-provider-falls-back ()
  (with-ac-php-buffer-test "<?php\n$ordinary"
    (goto-char (point-max))
    (let ((ac-php-extra-completion-functions nil))
      (should (equal (company-ac-php--prefix) "$ordinary")))))

(provide 'ac-php-extension-test)
;;; ac-php-extension-test.el ends here
