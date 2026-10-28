;;; ac-php-type-definition-test.el --- PHPStan alias navigation -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPDoc alias definition navigation through the public jump command.

;;; Code:

(defun ac-php-test--with-type-definition-project (sources function)
  "Call FUNCTION with tags and a directory containing SOURCES.
Each source is (FILENAME CLASSES CONTENT); CONTENT may contain |CURSOR|."
  (let* ((directory (make-temp-file "ac-php-type-definition-" t))
         (files (vconcat (mapcar #'car sources)))
         (class-map (make-hash-table :test #'equal))
         (function-map (make-hash-table :test #'equal))
         (tags (list class-map function-map
                     (make-hash-table :test #'equal) files directory)))
    (unwind-protect
        (progn
          (cl-loop for source in sources for index from 0 do
                   (let ((file (expand-file-name (car source) directory))
                         (content (nth 2 source)))
                     (with-temp-file file (insert content))
                     (dolist (class (nth 1 source))
                       (let ((line
                              (with-temp-buffer
                                (insert content)
                                (goto-char (point-min))
                                (re-search-forward
                                 (concat "\\(?:class\\|trait\\|interface\\|enum\\)[ \t]+"
                                         (regexp-quote
                                          (car (last (split-string class "\\\\" t))))
                                         "\\b") nil t)
                                (line-number-at-pos))))
                         (puthash class [] class-map)
                         (puthash class
                                  (vector "c" class ""
                                          (format "%d:%d" index line) class)
                                  function-map)))))
          (save-window-excursion (funcall function tags directory)))
      (dotimes (index (length files))
        (let ((buffer (find-buffer-visiting
                       (expand-file-name (aref files index) directory))))
          (when buffer
            (with-current-buffer buffer (set-buffer-modified-p nil))
            (kill-buffer buffer))))
      (delete-directory directory t))))

(defconst ac-php-test--type-definition-source
  "<?php
namespace Acme;
/**
 * @phpstan-type Config array{source: int}
 */
final class Types {}
")

(defun ac-php-test--type-definition-consumer (declarations annotation &optional preamble)
  "Return a consumer with DECLARATIONS, ANNOTATION and PREAMBLE."
  (concat "<?php\n" (or preamble "namespace Acme;\n")
          "/**\n" declarations "\n */\nclass Consumer {\n"
          "/** " annotation " */\n"
          "public function run(array $config = []): array { return $config; }\n}\n"))

(defun ac-php-test--visit-type-definition-reference (directory)
  "Visit Consumer.php in DIRECTORY and remove its cursor marker."
  (switch-to-buffer (find-file-noselect (expand-file-name "Consumer.php" directory)))
  (goto-char (point-min))
  (search-forward "|CURSOR|")
  (replace-match "" t t))

(defun ac-php-test--jump-to-type-definition (tags directory filename name &optional expression)
  "Jump using TAGS to NAME in FILENAME within DIRECTORY, then return.
When provided, EXPRESSION must occur on the destination's definition line."
  (ac-php-test--visit-type-definition-reference directory)
  (let ((source-buffer (current-buffer))
        (source-pos (point))
        (source-location (ac-php-current-location))
        (ac-php-location-stack nil)
        (ac-php-location-stack-index 0))
    (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
      (ac-php-find-symbol-at-point)
      (should (equal (buffer-file-name) (expand-file-name filename directory)))
      (should (looking-at (concat (regexp-quote name) "\\_>")))
      (should
       (string-match-p
        "@phpstan-type[ \t]+\\'"
        (buffer-substring-no-properties (line-beginning-position) (point))))
      (when expression
        (should
         (string-match-p
          (regexp-quote expression)
          (buffer-substring-no-properties
           (line-beginning-position) (line-end-position)))))
      (should (equal (car ac-php-location-stack) source-location))
      (ac-php-location-stack-back)
      (should (eq (current-buffer) source-buffer))
      (should (= (point) source-pos)))))

(ert-deftest ac-php-type-definition/imported-return-from-any-token-position ()
  (dolist (reference '("|CURSOR|Config" "Con|CURSOR|fig" "Config|CURSOR|"))
    (ac-php-test--with-type-definition-project
     (list
      (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
      (list "Consumer.php" '("\\Acme\\Consumer")
            (ac-php-test--type-definition-consumer
             " * @phpstan-import-type Config from Types"
             (concat "@return " reference))))
     (lambda (tags directory)
       (ac-php-test--jump-to-type-definition
        tags directory "Types.php" "Config" "array{source: int}")))))

(ert-deftest ac-php-type-definition/local-alias-keeps-class-scope ()
  (ac-php-test--with-type-definition-project
   (list
    (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
    (list "Consumer.php" '("\\Acme\\Consumer" "\\Acme\\Other")
          (concat
           (ac-php-test--type-definition-consumer
            " * @phpstan-type Config array{local: string}"
            "@return Con|CURSOR|fig")
           "/** @phpstan-type Config array{wrong: bool} */\nclass Other {}\n")))
   (lambda (tags directory)
     (ac-php-test--jump-to-type-definition
      tags directory "Consumer.php" "Config" "array{local: string}"))))

(ert-deftest ac-php-type-definition/same-file-import-without-class-tags ()
  (let ((consumer
         (ac-php-test--type-definition-consumer
          " * @phpstan-import-type Config from Types" "@return Con|CURSOR|fig")))
    (ac-php-test--with-type-definition-project
     (list
      (list "Consumer.php" '("\\Acme\\Types" "\\Acme\\Consumer")
            (concat ac-php-test--type-definition-source
                    (substring consumer (length "<?php\nnamespace Acme;\n")))))
     (lambda (tags directory)
       (clrhash (ac-php-g--function-map tags))
       (ac-php-test--jump-to-type-definition
        tags directory "Consumer.php" "Config" "array{source: int}")))))

(ert-deftest ac-php-type-definition/import-as-preserves-local-and-source-scopes ()
  (dolist (reference '("Config" "Options"))
    (ac-php-test--with-type-definition-project
     (list
      (list "Types.php" '("\\Acme\\Types" "\\Acme\\OtherTypes")
            (concat ac-php-test--type-definition-source
                    "/** @phpstan-type Config array{wrong: bool} */\nclass OtherTypes {}\n"))
      (list "Consumer.php" '("\\Acme\\Consumer")
            (ac-php-test--type-definition-consumer
             (concat " * @phpstan-import-type Config from Types as Options\n"
                     " * @phpstan-type Config array{local: string}")
             (concat "@return |CURSOR|" reference))))
     (lambda (tags directory)
       (ac-php-test--jump-to-type-definition
        tags directory
        (if (equal reference "Config") "Consumer.php" "Types.php") "Config"
        (if (equal reference "Config") "array{local: string}" "array{source: int}"))))))

(ert-deftest ac-php-type-definition/renamed-transitive-import-finds-original-definition ()
  (ac-php-test--with-type-definition-project
   (list
    (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
    '("Forward.php" ("\\Acme\\Forward")
      "<?php\nnamespace Acme;\n/** @phpstan-import-type Config from Types as ForwardConfig */\nclass Forward {}\n")
    (list "Consumer.php" '("\\Client\\Consumer")
          (ac-php-test--type-definition-consumer
           " * @phpstan-import-type ForwardConfig from Holder as Options"
           "@return Opt|CURSOR|ions"
           "namespace Client;\nuse Acme\\Forward as Holder;\n")))
   (lambda (tags directory)
     (ac-php-test--jump-to-type-definition tags directory "Types.php" "Config"))))

(ert-deftest ac-php-type-definition/adjacent-source-without-class-tags ()
  (ac-php-test--with-type-definition-project
   (list
    (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
    (list "Consumer.php" '("\\Acme\\Consumer")
          (ac-php-test--type-definition-consumer
           " * @phpstan-import-type Config from Types" "@return Con|CURSOR|fig")))
   (lambda (tags directory)
     (clrhash (ac-php-g--function-map tags))
     (ac-php-test--jump-to-type-definition tags directory "Types.php" "Config"))))

(ert-deftest ac-php-type-definition/uses-current-unsaved-source-position ()
  (ac-php-test--with-type-definition-project
   (list
    (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
    (list "Consumer.php" '("\\Acme\\Consumer")
          (ac-php-test--type-definition-consumer
           " * @phpstan-import-type Config from Types" "@return Con|CURSOR|fig")))
   (lambda (tags directory)
     (with-current-buffer (find-file-noselect (expand-file-name "Types.php" directory))
       (goto-char (point-min))
       (search-forward "/**")
       (insert "\n * Newly inserted comment line.\n * Another comment line."))
     (ac-php-test--jump-to-type-definition tags directory "Types.php" "Config"))))

(ert-deftest ac-php-type-definition/other-phpdoc-type-positions ()
  (dolist (annotation '("@param array<string, Con|CURSOR|fig> $config"
                        "@var Con|CURSOR|fig $config"
                        "@return list<Con|CURSOR|fig>|false"))
    (ac-php-test--with-type-definition-project
     (list
      (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
      (list "Consumer.php" '("\\Acme\\Consumer")
            (ac-php-test--type-definition-consumer
             " * @phpstan-import-type Config from Types" annotation)))
     (lambda (tags directory)
       (ac-php-test--jump-to-type-definition tags directory "Types.php" "Config")))))

(ert-deftest ac-php-type-definition/import-declaration-reference-finds-original ()
  (dolist (declaration
           '(" * @phpstan-import-type Con|CURSOR|fig from Types as Options"
             " * @phpstan-import-type Config from Types as Opt|CURSOR|ions"))
    (ac-php-test--with-type-definition-project
     (list
      (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
      (list "Consumer.php" '("\\Acme\\Consumer")
            (ac-php-test--type-definition-consumer declaration "@return Options")))
     (lambda (tags directory)
       (ac-php-test--jump-to-type-definition tags directory "Types.php" "Config")))))

(ert-deftest ac-php-type-definition/cycles-and-missing-types-leave-point-and-stack ()
  (dolist (declaration
           '(" * @phpstan-import-type Loop from Types"
             " * @phpstan-import-type Loop from Missing"
             " * @phpstan-import-type Unknown from Types as Loop"))
    (ac-php-test--with-type-definition-project
     (list
      '("Types.php" ("\\Acme\\Types")
        "<?php\nnamespace Acme;\n/** @phpstan-import-type Loop from Forward */\nclass Types {}\n")
      '("Forward.php" ("\\Acme\\Forward")
        "<?php\nnamespace Acme;\n/** @phpstan-import-type Loop from Types */\nclass Forward {}\n")
      (list "Consumer.php" '("\\Acme\\Consumer")
            (ac-php-test--type-definition-consumer declaration "@return Lo|CURSOR|op")))
     (lambda (tags directory)
       (ac-php-test--visit-type-definition-reference directory)
       (let ((buffer (current-buffer)) (position (point))
             (ac-php-location-stack nil) (ac-php-location-stack-index 0))
         (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
           (ac-php-find-symbol-at-point)
           (should (eq (current-buffer) buffer))
           (should (= (point) position))
           (should-not ac-php-location-stack)))))))

(ert-deftest ac-php-type-definition/non-phpdoc-symbols-keep-normal-lookup ()
  (dolist (expression '("$value = Con|CURSOR|fig;"
                        "$value = 'Con|CURSOR|fig';"
                        "// Con|CURSOR|fig\n"))
    (ac-php-test--with-type-definition-project
     (list
      (list "Types.php" '("\\Acme\\Types") ac-php-test--type-definition-source)
      (list "Consumer.php" '("\\Acme\\Consumer")
            (concat
             "<?php\nnamespace Acme;\n"
             "/** @phpstan-import-type Config from Types */\nclass Consumer {\n"
             "public function run() { " expression " }\n}\n")))
     (lambda (tags directory)
       (ac-php-test--visit-type-definition-reference directory)
       (let ((buffer (current-buffer)) (position (point))
             (calls 0) (ac-php-location-stack nil)
             (ac-php-location-stack-index 0))
         (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags))
                   ((symbol-function 'ac-php-find-symbol-at-point-pri)
                    (lambda (&rest _arguments) (cl-incf calls) nil)))
           (ac-php-find-symbol-at-point)
           (should (> calls 0))
           (should (eq (current-buffer) buffer))
           (should (= (point) position))
           (should-not ac-php-location-stack)))))))

(provide 'ac-php-type-definition-test)
;;; ac-php-type-definition-test.el ends here
