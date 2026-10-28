;;; ac-php-assignment-array-test.el --- Typed assignment arrays -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPDoc-typed array assignment keys, including empty bare key slots.

;;; Code:

(defconst ac-php-test--assignment-alias-doc
  (concat
   "/**\n"
   " * @phpstan-type Form array{field_type?: string, placeholder?: string}\n"
   " * @phpstan-type Field array{min?: int, max?: int, batch_edit?: bool, "
   "required?: bool, optional?: bool, form?: Form|null}\n"
   " */\n"))

(defconst ac-php-test--assignment-field-keys
  '("min" "max" "batch_edit" "required" "optional" "form"))

(defun ac-php-test--assignment-content (type literal &optional aliases)
  "Build an assignment of LITERAL annotated with TYPE and ALIASES."
  (concat "<?php\nnamespace Acme;\n"
          (or aliases ac-php-test--assignment-alias-doc)
          "class Consumer {\npublic function run() {\n"
          "/**\n * @var          " type "       $config\n */\n"
          "$config = " literal ";\n}\n}\n"))

(defun ac-php-test--assignment-array-candidates (content &optional frontend tags filename)
  "Complete CONTENT through FRONTEND, using TAGS and FILENAME when supplied."
  (with-ac-php-buffer-test content
    (when filename (setq buffer-file-name filename))
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((position (point))
          (tags (or tags
                    (list (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal) [] "/project/"))))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (prog1
            (pcase frontend
              ('company (company-ac-php-candidate ""))
              ('auto-complete
               (let ((ac-prefix (company-ac-php--prefix-symbol)))
                 (ac-php-candidate-ac)))
              (_ (ac-php-candidate)))
          (should (= (point) position)))))))

(ert-deftest ac-php-assignment-array/root-shape-quoted-and-bare-keys ()
  (dolist (literal '("[|CURSOR|]" "['|CURSOR|']" "[\"|CURSOR|\"]"))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal
        (ac-php-test--assignment-array-candidates
         (ac-php-test--assignment-content
          "array{required?: bool, optional?: bool}|null" literal)
         frontend)
        '("required" "optional"))))))

(ert-deftest ac-php-assignment-array/user-field-map-completes-unused-keys ()
  (dolist (frontend '(core company auto-complete))
    (should
     (equal
      (ac-php-test--assignment-array-candidates
       (ac-php-test--assignment-content
        "array<string, Field|null>"
        (concat "[\n 'port' => [\n"
                "  'min' => 1, 'max' => 65535, 'batch_edit' => true,\n"
                "  |CURSOR|\n ]\n]"))
       frontend)
      '("required" "optional" "form")))))

(ert-deftest ac-php-assignment-array/map-list-and-null-unions ()
  (dolist (example
           '(("array<string, Field|null>|null" . "['port' => [|CURSOR|]]")
             ("array<int, Field|null>" . "[2 => [|CURSOR|]]")
             ("list<Field|null>|null" . "[[|CURSOR|]]")
             ("Field[]|null" . "[[|CURSOR|]]")))
    (should
     (equal
      (ac-php-test--assignment-array-candidates
       (ac-php-test--assignment-content (car example) (cdr example)))
      ac-php-test--assignment-field-keys))))

(ert-deftest ac-php-assignment-array/nested-local-alias-in-map-value ()
  (dolist (literal '("['port' => ['form' => [|CURSOR|]]]"
                     "['port' => ['form' => ['|CURSOR|']]]"))
    (should
     (equal
      (ac-php-test--assignment-array-candidates
       (ac-php-test--assignment-content "array<string, Field|null>" literal))
      '("field_type" "placeholder")))))

(ert-deftest ac-php-assignment-array/imported-alias-retains-nested-source-scope ()
  (let* ((directory (make-temp-file "ac-php-assignment-types-" t))
         (file (expand-file-name "GroupConfigTypes.php" directory))
         (class "\\Acme\\GroupConfigTypes")
         (function-map (make-hash-table :test #'equal))
         (tags (list (make-hash-table :test #'equal) function-map
                     (make-hash-table :test #'equal)
                     ["GroupConfigTypes.php"] directory)))
    (unwind-protect
        (progn
          (with-temp-file file
            (insert
             "<?php\nnamespace Acme;\n/**\n"
             " * @phpstan-type GroupConfigForm array{field_type?: string, placeholder?: string}\n"
             " * @phpstan-type GroupConfigField array{required?: bool, optional?: bool, form?: GroupConfigForm|null}\n"
             " */\nfinal class GroupConfigTypes {}\n"))
          (puthash class (vector "c" class "" "0:7" class) function-map)
          (dolist (frontend '(core company auto-complete))
            (should
             (equal
              (ac-php-test--assignment-array-candidates
               (ac-php-test--assignment-content
                "array<string, ImportedField|null>"
                "['port' => ['form' => [|CURSOR|]]]"
                (concat "/**\n"
                        " * @phpstan-import-type GroupConfigField from GroupConfigTypes as ImportedField\n"
                        " * @phpstan-type GroupConfigForm array{wrong: int}\n */\n"))
               frontend tags (expand-file-name "Consumer.php" directory))
              '("field_type" "placeholder")))))
      (delete-directory directory t))))

(ert-deftest ac-php-assignment-array/filters-only-current-level-used-keys ()
  (dolist (literal
           '("['host' => ['required' => true, 'optional' => false], 'port' => ['min' => 1, |CURSOR|, 'max' => 65535]]"
             "['port' => ['min' => 1, |CURSOR|, 'max' => 65535], 'host' => ['required' => true, 'optional' => false]]"))
    (should
     (equal
      (ac-php-test--assignment-array-candidates
       (ac-php-test--assignment-content "array<string, Field|null>" literal))
      '("batch_edit" "required" "optional" "form")))))

(ert-deftest ac-php-assignment-array/current-edited-key-remains-a-candidate ()
  (should
   (equal
    (ac-php-test--assignment-array-candidates
     (ac-php-test--assignment-content
      "Field" "['min' => 1, 'req|CURSOR|uired' => true, 'max' => 65535]"))
    '("batch_edit" "required" "optional" "form"))))

(ert-deftest ac-php-assignment-array/prefix-is-correct-with-and-without-quotes ()
  (dolist (entry '(("[|CURSOR|]" . "")
                   ("[req|CURSOR|]" . "req")
                   ("['req|CURSOR|']" . "req")
                   ("[\"req|CURSOR|\"]" . "req")))
    (with-ac-php-buffer-test
        (ac-php-test--assignment-content "Field" (car entry))
      (search-forward "|CURSOR|")
      (replace-match "" t t)
      (let ((position (point))
            (context (ac-php--array-key-context)))
        (should (equal (plist-get context :prefix) (cdr entry)))
        (should (equal (company-ac-php--prefix) (cons (cdr entry) t)))
        (should (= (point) position))))
    (should
     (equal
      (ac-php-test--assignment-array-candidates
       (ac-php-test--assignment-content "Field" (car entry)))
      ac-php-test--assignment-field-keys))))

(ert-deftest ac-php-assignment-array/comments-and-unclosed-nested-array ()
  (should
   (equal
    (ac-php-test--assignment-array-candidates
     (ac-php-test--assignment-content
      "array<string, Field|null>"
      "[/* map */ 'port' => [\n 'min' => 1, /* remaining fields */ |CURSOR|"))
    '("max" "batch_edit" "required" "optional" "form"))))

(ert-deftest ac-php-assignment-array/value-and-comment-positions-do-not-complete ()
  (dolist (literal '("['required' => |CURSOR|]"
                     "['required' => 'req|CURSOR|']"
                     "['required' => req|CURSOR|]"
                     "['required' => true /* req|CURSOR| */]"
                     "[// req|CURSOR|\n]"
                     "[/* req|CURSOR| */]"
                     "transform([|CURSOR|])"))
    (let ((content (ac-php-test--assignment-content "Field" literal)))
      (unless (string-prefix-p "transform(" literal)
        (with-ac-php-buffer-test content
          (search-forward "|CURSOR|")
          (replace-match "" t t)
          (should-not (ac-php--array-key-context))))
      (should-not
       (cl-find-if
        (lambda (candidate)
          (equal (get-text-property 0 'ac-php-tag-type candidate) "a"))
        (ac-php-test--assignment-array-candidates content))))))

(ert-deftest ac-php-assignment-array/untyped-and-other-function-variables-do-not-complete ()
  (dolist (content
           '("<?php\nfunction run() { $config = [|CURSOR|]; }"
             "<?php\nfunction run() {\n/** @var array{required?: bool} $other */\n$config = [|CURSOR|]; }"
             "<?php\nfunction first() {\n/** @var array{required?: bool} $config */\n$config = [];\n}\nfunction second() {\n$config = [|CURSOR|];\n}"))
    (should-not (ac-php-test--assignment-array-candidates content))))

(provide 'ac-php-assignment-array-test)
;;; ac-php-assignment-array-test.el ends here
