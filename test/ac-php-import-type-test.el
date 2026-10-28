;;; ac-php-import-type-test.el --- Imported PHPStan aliases -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise imported aliases through public array-key completion entry points.

;;; Code:

(defun ac-php-test--with-import-project (sources function)
  "Call FUNCTION with tags and a directory containing SOURCES.
Each source is (FILENAME CLASSES CONTENT), with project-relative filenames."
  (let* ((directory (make-temp-file "ac-php-import-" t))
         (class-map (make-hash-table :test #'equal))
         (function-map (make-hash-table :test #'equal))
         (files (vconcat (mapcar #'car sources)))
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
          (funcall function tags directory))
      (delete-directory directory t))))

(defun ac-php-test--import-content (declarations type &optional path preamble)
  "Return a consumer of TYPE with DECLARATIONS, PATH and PREAMBLE."
  (concat "<?php\n" (or preamble "namespace Acme;\n")
          "/**\n" declarations "\n */\nclass Consumer {\n"
          "/** @param " type " $config */\n"
          "public function run($config) {\n"
          "  $config" path "['|CURSOR|'];\n}\n}\n"))

(defun ac-php-test--import-candidates (content tags directory &optional frontend)
  "Complete CONTENT using TAGS in DIRECTORY through FRONTEND."
  (with-ac-php-buffer-test content
    (setq buffer-file-name (expand-file-name "Consumer.php" directory))
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((position (point)))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (prog1
            (mapcar
             #'substring-no-properties
             (pcase frontend
               ('company (company-ac-php-candidate ""))
               ('auto-complete
                (let ((ac-prefix (company-ac-php--prefix-symbol)))
                  (ac-php-candidate-ac)))
               (_ (ac-php-candidate))))
          (should (= position (point))))))))

(defconst ac-php-test--import-types
  "<?php
namespace Acme;
/**
 * @phpstan-type Item array{name: string, enabled?: bool}
 * @phpstan-type Config array{id: int, items: list<Item>, fields: array<string, Item>}
 */
final class Types {}
")

(ert-deftest ac-php-import-type/same-namespace-all-frontends ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (dolist (frontend '(core company auto-complete))
       (should
        (equal
         (ac-php-test--import-candidates
          (ac-php-test--import-content
           " * @phpstan-import-type Config from Types" "Config")
          tags directory frontend)
         '("id" "items" "fields")))))))

(ert-deftest ac-php-import-type/class-names-and-renamed-alias ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (dolist (reference
              '(("\\Acme\\Types" . "namespace Client;\n")
                ("ImportedTypes" . "namespace Client;\nuse Acme\\Types as ImportedTypes;\n")
                ("Types" . "namespace Client;\nuse Acme\\Types;\n")
                ("Schema\\Types" . "namespace Client;\nuse Acme as Schema;\n")
                ("Types" . "namespace Client;\nuse Acme\\{Types, OtherTypes};\n")
                ("ImportedTypes" . "namespace Client;\nuse Acme\\Types as ImportedTypes, Acme\\OtherTypes;\n")
                ("namespace\\Types" . "namespace Acme;\n")))
       (should
        (equal
         (ac-php-test--import-candidates
          (ac-php-test--import-content
           (concat " * @phpstan-import-type Config from " (car reference)
                   " as Options")
           "Options" nil (cdr reference))
          tags directory)
         '("id" "items" "fields")))))))

(ert-deftest ac-php-import-type/nested-dependencies-keep-source-scope ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (dolist (path '("['items'][0]" "['fields']['port']"))
       (should
        (equal
         (ac-php-test--import-candidates
          (ac-php-test--import-content
           (concat " * @phpstan-import-type Config from Types as Options\n"
                   " * @phpstan-type Item array{wrong: int}")
           "Options" path)
          tags directory)
         '("name" "enabled"))))
     (should
      (equal
       (ac-php-test--import-candidates
        (ac-php-test--import-content
         (concat " * @phpstan-import-type Config from Types\n"
                 " * @phpstan-type Item array{local: int}")
         "Item") tags directory)
       '("local"))))))

(ert-deftest ac-php-import-type/transitive-imports ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types)
     ("Forward.php" ("\\Acme\\Forward")
      "<?php\nnamespace Acme;\n/**
 * @phpstan-import-type Config from Types as Base
 * @phpstan-type Wrapped array{data: Base}
 */
class Forward {}\n"))
   (lambda (tags directory)
     (should
      (equal
       (ac-php-test--import-candidates
        (ac-php-test--import-content
         " * @phpstan-import-type Wrapped from Forward" "Wrapped" "['data']['items'][0]")
        tags directory)
       '("name" "enabled"))))))

(ert-deftest ac-php-import-type/recursive-alias-and-cyclic-imports ()
  (ac-php-test--with-import-project
   '(("Types.php" ("\\Acme\\Types")
      "<?php\nnamespace Acme;\n/**
 * @phpstan-import-type Loop from Forward
 * @phpstan-type Node array{id: int, children: list<Node>}
 */
class Types {}\n")
     ("Forward.php" ("\\Acme\\Forward")
      "<?php\nnamespace Acme;\n/** @phpstan-import-type Loop from Types */\nclass Forward {}\n"))
   (lambda (tags directory)
     (should
      (equal
       (ac-php-test--import-candidates
        (ac-php-test--import-content
         " * @phpstan-import-type Node from Types" "Node" "['children'][0]")
        tags directory)
       '("id" "children")))
     (should-not
      (ac-php-test--import-candidates
       (ac-php-test--import-content
        " * @phpstan-import-type Loop from Types" "Loop") tags directory)))))

(ert-deftest ac-php-import-type/missing-source-or-alias ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (dolist (declaration
              '(" * @phpstan-import-type Missing from Types"
                " * @phpstan-import-type Missing from Unknown"))
       (should-not
        (ac-php-test--import-candidates
         (ac-php-test--import-content declaration "Missing") tags directory)))
     (delete-file (expand-file-name "Types.php" directory))
     (should-not
      (ac-php-test--import-candidates
       (ac-php-test--import-content
        " * @phpstan-import-type Config from Types" "Config") tags directory)))))

(ert-deftest ac-php-import-type/unsaved-source-buffer-takes-precedence ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (let ((buffer (find-file-noselect (expand-file-name "Types.php" directory))))
       (unwind-protect
           (progn
             (with-current-buffer buffer
               (goto-char (point-min))
               (search-forward "id: int")
               (replace-match "updated: string" t t))
             (should
              (equal
               (ac-php-test--import-candidates
                (ac-php-test--import-content
                 " * @phpstan-import-type Config from Types" "Config")
                tags directory)
               '("updated" "items" "fields"))))
         (with-current-buffer buffer (set-buffer-modified-p nil))
         (kill-buffer buffer))))))

(ert-deftest ac-php-import-type/uses-requested-class-within-source-file ()
  (ac-php-test--with-import-project
   '(("Types.php" ("\\Acme\\Types" "\\Acme\\OtherTypes")
      "<?php\nnamespace Acme;\n/** @phpstan-type Config array{expected: int} */
class Types {}
/** @phpstan-type Config array{unrelated: bool} */
class OtherTypes {}\n"))
   (lambda (tags directory)
     (should
      (equal
       (ac-php-test--import-candidates
        (ac-php-test--import-content
         " * @phpstan-import-type Config from Types" "Config") tags directory)
       '("expected"))))))

(ert-deftest ac-php-import-type/source-interfaces-and-readonly-classes ()
  (dolist (declaration '("interface" "readonly class" "final readonly class"))
    (ac-php-test--with-import-project
     (list
      (list "Types.php" '("\\Acme\\Types")
            (concat "<?php\nnamespace Acme;\n"
                    "/** @phpstan-type Config array{id: int} */\n"
                    declaration " Types {}\n")))
     (lambda (tags directory)
       (should
        (equal
         (ac-php-test--import-candidates
          (ac-php-test--import-content
           " * @phpstan-import-type Config from Types" "Config")
          tags directory)
         '("id")))))))

(ert-deftest ac-php-import-type/class-attributes-retain-type-docs ()
  (ac-php-test--with-import-project
   '(("Types.php" ("\\Acme\\Types")
      "<?php\nnamespace Acme;\n/** @phpstan-type Config array{id: int} */
#[Example(values: [']', [1, 2]])]
#[AnotherExample]
final readonly class Types {}\n"))
   (lambda (tags directory)
     (dolist (declaration '("class" "readonly class" "final readonly class"))
       (should
        (equal
         (ac-php-test--import-candidates
          (concat
           "<?php\nnamespace Acme;\n"
           "/** @phpstan-type Config array{before: int} */\nclass Before {}\n"
           "/** @phpstan-import-type Config from Types */\n#[Example]\n"
           declaration " Consumer {\n"
           "/** @param Config $config */\npublic function run($config) {\n"
           "  $config['|CURSOR|'];\n}\n}\n"
           "/** @phpstan-type Config array{after: int} */\nclass After {}\n")
          tags directory)
         '("id")))))))

(ert-deftest ac-php-import-type/interface-consumer-keeps-its-scope ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags _directory)
     (with-ac-php-buffer-test
         (concat
          "<?php\nnamespace Acme;\n"
          "/** @phpstan-type Config array{before: int} */\nclass Before {}\n"
          "/** @phpstan-import-type Config from Types */\n#[Example]\n"
          "interface Consumer {\npublic function run(array $config|CURSOR|): void;\n}\n"
          "/** @phpstan-type Config array{after: int} */\nclass After {}\n")
       (search-forward "|CURSOR|")
       (replace-match "" t t)
       (should
        (equal
         (mapcar #'car
                 (ac-php--array-shapes-fields
                  (ac-php--array-shapes-from-type
                   "Config" (ac-php--phpstan-type-aliases tags))))
         '("id" "items" "fields")))))))

(ert-deftest ac-php-import-type/same-file-source-without-class-tags ()
  (ac-php-test--with-import-project
   nil
   (lambda (tags directory)
     (let ((consumer (ac-php-test--import-content
                      " * @phpstan-import-type Config from Types" "Config")))
       (should
        (equal
         (ac-php-test--import-candidates
          (concat ac-php-test--import-types
                  (substring consumer (length "<?php\nnamespace Acme;\n")))
          tags directory)
         '("id" "items" "fields")))))))

(ert-deftest ac-php-import-type/adjacent-source-without-class-tags ()
  (ac-php-test--with-import-project
   `(("Types.php" ("\\Acme\\Types") ,ac-php-test--import-types))
   (lambda (tags directory)
     (clrhash (ac-php-g--function-map tags))
     (should
      (equal
       (ac-php-test--import-candidates
        (ac-php-test--import-content
         " * @phpstan-import-type Config from Types" "Config") tags directory)
       '("id" "items" "fields"))))))

(ert-deftest ac-php-import-type/buffer-aliases-preserve-keys-and-recursive-elements ()
  (ac-php-test--with-import-project
   nil
   (lambda (tags directory)
     (should
      (equal
       (ac-php-test--import-candidates
        (concat "<?php\n"
                "/** @phpstan-type Item array{Item: string, child?: Item} */\n"
                "/** @param list<Item> $items */\n"
                "function run($items) { $items[0]['child']['|CURSOR|']; }\n")
        tags directory)
       '("Item" "child"))))))

(provide 'ac-php-import-type-test)
;;; ac-php-import-type-test.el ends here
