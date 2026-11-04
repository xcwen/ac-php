;;; ac-php-documentation-test.el --- Source PHPDoc tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPDoc lookup and the public symbol documentation command.

;;; Code:

(defun ac-php-test--with-documentation-source (content function)
  "Call FUNCTION with tags and a temporary PHP file containing CONTENT."
  (let* ((directory (make-temp-file "ac-php-documentation-" t))
         (file (expand-file-name "Source.php" directory))
         (tags (list (make-hash-table :test 'case-fold)
                     (make-hash-table :test 'case-fold)
                     (make-hash-table :test 'case-fold)
                     (vector file) directory))
         (ac-php--source-buffers (make-hash-table :test #'equal)))
    (unwind-protect
        (progn
          (with-temp-file file (insert content))
          (funcall function tags file))
      (let ((buffer (get-file-buffer file)))
        (when buffer
          (with-current-buffer buffer (set-buffer-modified-p nil))
          (kill-buffer buffer)))
      (maphash (lambda (_ entry)
                 (when (buffer-live-p (cdr entry)) (kill-buffer (cdr entry))))
               ac-php--source-buffers)
      (delete-directory directory t))))

(defun ac-php-test--documentation-tag (file kind name declaration &optional owner)
  "Build a tag for KIND and NAME at DECLARATION in FILE, optionally with OWNER."
  (let ((location
         (with-temp-buffer
           (insert-file-contents file)
           (goto-char (point-min))
           (search-forward declaration)
           (format "0:%d" (line-number-at-pos)))))
    (if owner
        (vector kind name "$value" location "string" owner "public" "")
      (vector kind name "$value" location
              (if (member kind '("c" "i" "t")) name "string")))))

(defun ac-php-test--documentation-popup (content tags)
  "Return the popup for CONTENT at |CURSOR| using TAGS."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((position (point)) popup)
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags))
                ((symbol-function 'popup-tip)
                 (lambda (text &rest _) (setq popup text))))
        (ac-php-show-tip))
      (should (= position (point)))
      popup)))

(ert-deftest ac-php-documentation/function-keeps-description-and-annotations ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
/**
 * Build a greeting.
 *
 * Preserve the supplied name.
 * @param string $value The name.
 * @return string The greeting.
 * @throws InvalidArgumentException For an empty name.
 */
function greet($value) {}
"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "f" "\\App\\greet(" "function greet")))
       (should
        (equal (ac-php--tag-phpdoc tags tag)
               (concat "Build a greeting.\n\nPreserve the supplied name.\n"
                       "@param string $value The name.\n"
                       "@return string The greeting.\n"
                       "@throws InvalidArgumentException For an empty name.")))))))

(ert-deftest ac-php-documentation/declaration-layouts ()
  (dolist
      (example
       '(("f" "\\fetch(" nil "function fetch"
          "<?php\n/** Expected document. */ function fetch($value) {}")
         ("f" "\\fetch(" nil "fetch($value)"
          "<?php\n/** Expected document. */\n#[Route(']')]\nfunction\nfetch($value) {}")
         ("f" "\\fetch(" nil "fetch /* before parameters */"
          "<?php\n/** Expected document. */\nfunction /* after keyword */ & /* after reference */ fetch /* before parameters */ ($value) {}")
         ("m" "fetch(" "\\Service" "fetch($value)"
          "<?php\nclass Service {\n/** Expected document. */\n#[Route(']')]\nfinal public\nfunction\nfetch($value) {}\n}")
         ("p" "value" "\\Service" "$value;"
          "<?php\nclass Service {\n/** Expected document. */\n#[Field]\npublic readonly\n?\\App\\Value\n$value;\n}")
         ("p" "value" "\\Service" "$value ="
          "<?php\nclass Service {\n/** Expected document. */\npublic string $first = 'a', $value = 'b';\n}")
         ("d" "VALUE" "\\Service" "VALUE ="
          "<?php\nclass Service {\n/** Expected document. */\npublic const\nVALUE = 1;\n}")
         ("c" "\\Service" nil "Service {}"
          "<?php\n/** Expected document. */\n#[Entity(']')]\nfinal readonly\nclass\nService {}")))
    (ac-php-test--with-documentation-source
     (nth 4 example)
     (lambda (tags file)
       (let ((tag (ac-php-test--documentation-tag
                   file (nth 0 example) (nth 1 example)
                   (nth 3 example) (nth 2 example))))
         (should (equal (ac-php--tag-phpdoc tags tag)
                        "Expected document.")))))))

(ert-deftest ac-php-documentation/lookup-checks-scope-and-ignores-fake-declarations ()
  (ac-php-test--with-documentation-source
   "<?php
namespace Wrong;
/** Wrong function. */ function fetch($value) {}
namespace App;
$text = 'function fetch($value) {}';
/* function fetch($value) {} */
/** Correct function. */ function fetch($value) {}
class Other {
    /** Wrong method. */ public function fetch($value) {}
}
class Service {
    /** Correct method. */ public function fetch($value) {}
}
"
   (lambda (tags _file)
     ;; Deliberately stale line numbers must not select a namesake declaration.
     (should (equal (ac-php--tag-phpdoc
                     tags ["f" "\\App\\fetch(" "$value" "0:3" "string"])
                    "Correct function."))
     (should (equal (ac-php--tag-phpdoc
                     tags ["m" "fetch(" "$value" "0:9" "string"
                           "\\App\\Service" "public" ""])
                    "Correct method.")))))

(ert-deftest ac-php-documentation/no-document-does-not-use-another-declaration ()
  (ac-php-test--with-documentation-source
   "<?php
/** Documented function. */ function first($value) {}
function second($value) {}
/* Ordinary comment. */ function third($value) {}
"
   (lambda (tags file)
     (dolist (name '("second" "third"))
       (should-not
        (ac-php--tag-phpdoc
         tags (ac-php-test--documentation-tag
               file "f" (concat "\\" name "(") (concat "function " name))))))))

(ert-deftest ac-php-documentation/unsaved-source-with-shifted-lines-takes-precedence ()
  (ac-php-test--with-documentation-source
   "<?php\n/** Old document. */\nfunction fetch($value) {}\n"
   (lambda (tags file)
     (let* ((tag (ac-php-test--documentation-tag
                  file "f" "\\fetch(" "function fetch"))
            (buffer (find-file-noselect file)))
       (should (equal (ac-php--tag-phpdoc tags tag) "Old document."))
       (with-current-buffer buffer
         (erase-buffer)
         (insert "<?php\n/** Wrong document. */ function other() {}\n\n\n"
                 "/** Unsaved document. */\nfunction fetch($value) {}\n"))
       (should (equal (ac-php--tag-phpdoc tags tag) "Unsaved document."))))))

(ert-deftest ac-php-documentation/magic-members-use-their-own-annotations ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
/**
 * Service description.
 * @property string $name The display name.
 * @property int $age The age.
 * @method string fetch(string $value) Load a value.
 * @method void forget() Forget the value.
 */
class Service {}
"
   (lambda (tags file)
     (dolist (example '(("p" "name" "$name" "The display name." "The age.")
                        ("m" "fetch(" "@method string fetch" "Load a value."
                         "Forget the value.")))
       (let* ((tag (ac-php-test--documentation-tag
                    file (nth 0 example) (nth 1 example)
                    (nth 2 example) "\\App\\Service"))
              (doc (ac-php--tag-phpdoc tags tag)))
         (should (string-match-p (regexp-quote (nth 3 example)) doc))
         (should-not (string-match-p (regexp-quote (nth 4 example)) doc)))))))

(ert-deftest ac-php-documentation/magic-members-ignore-description-references-and-property-case ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
/**
 * @property string $Name Uppercase property.
 * @property string $other Alias of $name.
 * @property string $name Actual property.
 * @method void first() Call fetch() in its description.
 * @method string fetch() Actual method.
 */
class Service {}
"
   (lambda (tags file)
     (dolist (example '(("p" "name" "@property string $name"
                         "@property string $name Actual property.")
                        ("p" "Name" "@property string $Name"
                         "@property string $Name Uppercase property.")
                        ("m" "fetch(" "@method string fetch"
                         "@method string fetch() Actual method.")))
       (let ((tag (ac-php-test--documentation-tag
                   file (nth 0 example) (nth 1 example)
                   (nth 2 example) "\\App\\Service")))
         (should (equal (ac-php--tag-phpdoc tags tag) (nth 3 example))))))))

(ert-deftest ac-php-documentation/conditional-functions-use-the-tagged-declaration ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
if ($enabled) {
    /** First declaration. */
    function fetch($first) {}
} else {
    /** Second declaration. */
    function fetch($second, $fallback) {}
}
"
   (lambda (tags file)
     (let ((first (ac-php-test--documentation-tag
                   file "f" "\\App\\fetch(" "function fetch($first"))
           (second (ac-php-test--documentation-tag
                    file "f" "\\App\\fetch(" "function fetch($second")))
       (aset first 2 "$first")
       (aset second 2 "$second, $fallback")
       (should (equal (ac-php--tag-phpdoc tags first) "First declaration."))
       (should (equal (ac-php--tag-phpdoc tags second) "Second declaration."))
       (puthash "\\App\\fetch(" second (ac-php-g--function-map tags))
       (let ((popup (ac-php-test--documentation-popup
                     "<?php\nnamespace App;\nfetch|CURSOR|('value', 'default');" tags)))
         (should (string-match-p (regexp-quote "fetch($second, $fallback)") popup))
         (should (string-match-p "Second declaration\\.\\'" popup)))))))

(ert-deftest ac-php-documentation/show-tip-appends-function-document ()
  (ac-php-test--with-documentation-source
   "<?php\nnamespace App;\n/** Greet a visitor. */\nfunction greet($value) {}\n"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "f" "\\App\\greet(" "function greet")))
       (puthash (aref tag 1) tag (ac-php-g--function-map tags))
       (let ((popup (ac-php-test--documentation-popup
                     "<?php\nnamespace App;\ngreet|CURSOR|('Ada');" tags)))
         (should (string-match-p (regexp-quote "greet($value)") popup))
         (should (string-match-p (regexp-quote "[  type]:string") popup))
         (should (string-match-p "Greet a visitor\\.\\'" popup)))))))

(ert-deftest ac-php-documentation/show-tip-reads-inherited-member-document ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
class Base {
    /** Load a stored value. */
    public function fetch($value) {}
}
class Service extends Base {}
"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "m" "fetch(" "function fetch" "\\App\\Base")))
       (dolist (class '("Base" "Service"))
         (let ((name (concat "\\App\\" class)))
           (puthash name (ac-php-test--documentation-tag
                          file "c" name (concat "class " class))
                    (ac-php-g--function-map tags))))
       (puthash "\\App\\Base" (vector tag) (ac-php-g--class-map tags))
       (puthash "\\App\\Service" [] (ac-php-g--class-map tags))
       (puthash "\\App\\Service" ["\\App\\Base"] (ac-php-g--inherit-map tags))
       (let ((popup (ac-php-test--documentation-popup
                     (concat "<?php\nfunction run(\\App\\Service $service) {\n"
                             "$service->fetch|CURSOR|('key');\n}") tags)))
         (should (string-match-p (regexp-quote "fetch($value)") popup))
         (should (string-match-p (regexp-quote "[access]:public") popup))
         (should (string-match-p (regexp-quote "[  from]:\\App\\Base") popup))
         (should (string-match-p "Load a stored value\\.\\'" popup)))))))

(ert-deftest ac-php-documentation/constructor-uses-constructor-document ()
  (ac-php-test--with-documentation-source
   "<?php
namespace App;
/** Service class description. */
class Service {
    /** Build a service from a value. */
    public function __construct($value) {}
}
"
   (lambda (tags file)
     (let ((class-tag (ac-php-test--documentation-tag
                       file "c" "\\App\\Service" "class Service"))
           (constructor (ac-php-test--documentation-tag
                         file "f" "\\App\\Service(" "function __construct")))
       (aset constructor 4 "\\App\\Service")
       (puthash "\\App\\Service"
                (vector (ac-php-test--documentation-tag
                         file "m" "__construct(" "function __construct"
                         "\\App\\Service"))
                (ac-php-g--class-map tags))
       (puthash "\\App\\Service" class-tag (ac-php-g--function-map tags))
       (puthash "\\App\\Service(" constructor (ac-php-g--function-map tags))
       (should (equal (ac-php--tag-phpdoc tags class-tag)
                      "Service class description."))
       (let ((popup (ac-php-test--documentation-popup
                     "<?php\nnew \\App\\Service|CURSOR|('value');" tags)))
         (should (string-match-p "Build a service from a value\\.\\'" popup))
         (should-not (string-match-p "Service class description" popup)))))))

(ert-deftest ac-php-documentation/missing-source-and-system-symbols-keep-signatures ()
  (ac-php-test--with-documentation-source
   "<?php\nfunction fetch($value) {}\n"
   (lambda (tags file)
     (let ((system ["f" "\\strlen(" "$value" "sys" "int"])
           (tag ["f" "\\fetch(" "$value" "0:2" "string"]))
       (should-not (ac-php--tag-phpdoc tags system))
       (puthash "\\strlen(" system (ac-php-g--function-map tags))
       (should (equal (ac-php-test--documentation-popup
                       "<?php\nstrlen|CURSOR|('value');" tags)
                      "[system]:\\strlen($value)\n[  type]:int"))
       (delete-file file)
       (should-not (ac-php--tag-phpdoc tags tag))
       (puthash "\\fetch(" tag (ac-php-g--function-map tags))
       (should (equal (ac-php-test--documentation-popup
                       "<?php\nfetch|CURSOR|('value');" tags)
                      "[user]:\\fetch($value)\n[  type]:string"))))))

(ert-deftest ac-php-documentation/constructor-candidate-without-constructor-uses-class-doc ()
  (ac-php-test--with-documentation-source
   "<?php\nnamespace App;\n/** Service class description. */\nclass Service {}\n"
   (lambda (tags file)
     (let ((class-tag (ac-php-test--documentation-tag
                       file "c" "\\App\\Service" "class Service"))
           (constructor (ac-php-test--documentation-tag
                         file "f" "\\App\\Service(" "class Service")))
       (aset constructor 2 "")
       (aset constructor 4 "\\App\\Service")
       (puthash "\\App\\Service" class-tag (ac-php-g--function-map tags))
       (puthash "\\App\\Service(" constructor (ac-php-g--function-map tags))
       (puthash "\\App\\Service" [] (ac-php-g--class-map tags))
       (let ((candidate (ac-php--function-candidate constructor "Service(" tags)))
         (should (equal (ac-php--candidate-phpdoc candidate)
                        "Service class description.")))
       (should (string-match-p
                "Service class description\\.\\'"
                (ac-php-test--documentation-popup
                 "<?php\nnew \\App\\Service|CURSOR|();" tags)))))))

(ert-deftest ac-php-documentation/source-lookup-preserves-caller-state ()
  (ac-php-test--with-documentation-source
   "<?php\n/** Read the value. */\nfunction fetch($value) {}\n"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "f" "\\fetch(" "function fetch")))
       (with-ac-php-buffer-test "<?php\nfunction call() { fetch('value'); }\n"
         (search-forward "fetch")
         (narrow-to-region (line-beginning-position) (line-end-position))
         (string-match "\\(value\\)" "value")
         (let ((position (point)) (minimum (point-min)) (maximum (point-max))
               (data (match-data)))
           (should (equal (ac-php--tag-phpdoc tags tag) "Read the value."))
           (should (= position (point)))
           (should (= minimum (point-min)))
           (should (= maximum (point-max)))
           (should (equal data (match-data)))))))))

(ert-deftest ac-php-documentation/source-lookup-restores-live-source-narrowing ()
  (ac-php-test--with-documentation-source
   "<?php\n/** Read the value. */\nfunction fetch($value) {\n    return $value;\n}\n"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "f" "\\fetch(" "function fetch"))
           (buffer (find-file-noselect file)))
       (with-current-buffer buffer
         (goto-char (point-min))
         (search-forward "return")
         (narrow-to-region (line-beginning-position) (line-end-position))
         (let ((position (point)) (minimum (point-min)) (maximum (point-max)))
           ;; Both the declaration and its PHPDoc are outside the restriction.
           (should (equal (ac-php--tag-phpdoc tags tag) "Read the value."))
           (should (= position (point)))
           (should (= minimum (point-min)))
           (should (= maximum (point-max)))))))))

(provide 'ac-php-documentation-test)
;;; ac-php-documentation-test.el ends here
