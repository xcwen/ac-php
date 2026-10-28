;;; ac-php-array-key-insertion-test.el --- Array key insertion tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Check bare array-key insertion through both completion frontends.

;;; Code:

(defun ac-php-test--array-key-insertion (content frontend &optional key style)
  "Complete KEY at |CURSOR| in CONTENT using FRONTEND and candidate STYLE.
CONTENT already contains KEY, as it would after the frontend inserts it."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let* ((candidate (propertize (or key "required")
                                  'ac-php-tag-type "a"
                                  'ac-php-array-key-style (or style 'bare)
                                  'ac-php-help "bool"))
           (ac-last-completion (cons (copy-marker (point)) candidate)))
      (if (eq frontend 'company)
          (company-ac-php-backend-post-completion candidate)
        (ac-php-action))
      (insert "|CURSOR|")
      (buffer-substring-no-properties (point-min) (point-max)))))

(ert-deftest ac-php-array-key-insertion/bare-key-adds-quotes-and-arrow ()
  (dolist (frontend '(company auto-complete))
    (should
     (equal
      (ac-php-test--array-key-insertion
       "<?php\n$fields = ['port' => ['min' => 1, required|CURSOR|]];" frontend)
      "<?php\n$fields = ['port' => ['min' => 1, 'required' => |CURSOR|]];"))))

(ert-deftest ac-php-array-key-insertion/reuses-existing-arrow-and-value ()
  (dolist (frontend '(company auto-complete))
    (dolist (spacing '(" " "\n    " " /* keep */ "))
      (should
       (equal
        (ac-php-test--array-key-insertion
         (concat "<?php\n$fields = [required|CURSOR|" spacing "=> false];")
         frontend)
        (concat "<?php\n$fields = ['required'" spacing "=> |CURSOR|false];"))))))

(ert-deftest ac-php-array-key-insertion/replaces-existing-bare-key-suffix ()
  (dolist (frontend '(company auto-complete))
    (dolist (spacing '(" " " /* keep */ "))
      (should
       (equal
        (ac-php-test--array-key-insertion
         (concat "<?php\n$fields = [required|CURSOR|uired" spacing "=> false];")
         frontend)
        (concat "<?php\n$fields = ['required'" spacing "=> |CURSOR|false];"))))))

(ert-deftest ac-php-array-key-insertion/preserves-following-value-tokens ()
  (dolist (frontend '(company auto-complete))
    (dolist (suffix '("true" "$value" "value()" "other_key => false"))
      (let ((spacing (if (equal suffix "other_key => false") " " "")))
        (should
         (equal
          (ac-php-test--array-key-insertion
           (concat "<?php\n$fields = [required|CURSOR|" spacing suffix "];")
           frontend)
          (concat "<?php\n$fields = ['required' => |CURSOR|" spacing suffix "];")))))))

(ert-deftest ac-php-array-key-insertion/quoted-key-keeps-existing-behavior ()
  (dolist (frontend '(company auto-complete))
    (should
     (equal
      (ac-php-test--array-key-insertion
       "<?php\n$fields = ['required|CURSOR|' => false];"
       frontend nil 'quoted)
      "<?php\n$fields = ['required|CURSOR|' => false];"))))

(ert-deftest ac-php-array-key-insertion/escapes-single-quoted-key ()
  (dolist (frontend '(company auto-complete))
    (should
     (equal
      (ac-php-test--array-key-insertion
       "<?php\n$fields = [user's\\path|CURSOR|];" frontend "user's\\path")
      "<?php\n$fields = ['user\\'s\\\\path' => |CURSOR|];"))))

(ert-deftest ac-php-array-key-insertion/only-handles-marked-inserted-keys ()
  (with-ac-php-buffer-test "<?php\n$fields = [required"
    (goto-char (point-max))
    (let ((before (buffer-string)))
      (should-not (ac-php--array-key-post-completion "required"))
      (should-not
       (ac-php--array-key-post-completion
        (propertize "other" 'ac-php-tag-type "a"
                    'ac-php-array-key-style 'bare)))
      (should (equal before (buffer-string))))))

(ert-deftest ac-php-array-key-insertion/bare-prefix-starts-at-key-slot ()
  (dolist (prefix '("" "req"))
    (with-ac-php-buffer-test
        (concat "<?php\nfunction configure() {\n"
                "/** @var array{required: bool} $fields */\n"
                "$fields = [" prefix "|CURSOR|];\n}")
      (search-forward "|CURSOR|")
      (replace-match "" t t)
      (let ((pos (point)))
        (should (equal (company-ac-php--prefix) (cons prefix t)))
        (should (= (ac-php-prefix) (- pos (length prefix))))
        (should (= (point) pos))))))

(ert-deftest ac-php-array-key-insertion/completes-annotated-map-entry ()
  (dolist (frontend '(company auto-complete))
    (with-ac-php-buffer-test
        (concat "<?php\n/**\n"
                " * @phpstan-type Field array{min?: int, max?: int, "
                "batch_edit?: bool, required?: bool}\n"
                " */\nclass Config {\nfunction configure() {\n"
                "/** @var array<string, Field|null> $fields */\n"
                "$fields = ['port' => ['min' => 1, 'max' => 65535, "
                "'batch_edit' => true, req|CURSOR|]];\n}\n}")
      (search-forward "|CURSOR|")
      (replace-match "" t t)
      (let ((tags (list (make-hash-table :test #'equal)
                        (make-hash-table :test #'equal)
                        (make-hash-table :test #'equal)
                        [] "/project/")))
        (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
          (let* ((start (ac-php-prefix))
                 (candidate
                  (car (if (eq frontend 'company)
                           (company-ac-php-candidate "req")
                         (let ((ac-prefix "req")) (ac-php-candidate-ac))))))
            (should (equal candidate "required"))
            (should (eq (get-text-property 0 'ac-php-array-key-style candidate)
                        'bare))
            (delete-region start (point))
            (insert candidate)
            (if (eq frontend 'company)
                (company-ac-php-backend-post-completion candidate)
              (let ((ac-last-completion (cons (copy-marker start) candidate)))
                (ac-php-action)))
            (insert "|CURSOR|")
            (should (string-match-p
                     "'batch_edit' => true, 'required' => |CURSOR|"
                     (buffer-string)))))))))

(provide 'ac-php-array-key-insertion-test)
;;; ac-php-array-key-insertion-test.el ends here
