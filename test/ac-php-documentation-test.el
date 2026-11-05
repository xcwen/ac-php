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
         (should (string-match-p (regexp-quote "→ string") popup))
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
         (should (string-match-p (regexp-quote "· public ·") popup))
         (should (string-match-p (regexp-quote "\\App\\Base") popup))
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
                      "\\strlen($value) → int"))
       (delete-file file)
       (should-not (ac-php--tag-phpdoc tags tag))
       (puthash "\\fetch(" tag (ac-php-g--function-map tags))
       (should (equal (ac-php-test--documentation-popup
                       "<?php\nfetch|CURSOR|('value');" tags)
                      "\\fetch($value) → string"))))))

(ert-deftest ac-php-documentation/show-tip-formats-generated-phpdoc ()
  (ac-php-test--with-documentation-source
   "<?php
class Service {
    /**
     * testid ,
     *
     *
     * Generated from protobuf field <code>optional int32 id = 2;</code>
     * @return int
     */
    public function getId() {}
}
"
   (lambda (tags file)
     (let ((tag (ac-php-test--documentation-tag
                 file "m" "getId(" "function getId" "\\Service")))
       (aset tag 2 "")
       (aset tag 4 "int")
       (puthash "\\Service" (vector tag) (ac-php-g--class-map tags))
       (puthash "\\Service" ["c" "\\Service" "" "0:2" "\\Service"]
                (ac-php-g--function-map tags))
       (should
        (equal
         (ac-php-test--documentation-popup
          "<?php\nfunction run(\\Service $service) {\n$service->getId|CURSOR|();\n}" tags)
         (concat "getId() → int · public · \\Service\n\n"
                 "testid ,\n\nGenerated from protobuf field optional int32 id = 2;\n"
                 "@return int")))))))

(defun ac-php-test--documentation-popup-rows (document width)
  "Render DOCUMENT through the real tooltip refill path at WIDTH columns."
  (let ((popup-tip-max-width 120)
        (unread-command-events nil)
        initial-width rows)
    (cl-letf (((symbol-function 'popup-create)
               (lambda (_point proposed-width _height &rest _)
                 (setq initial-width proposed-width)
                 (make-popup :width width)))
              ((symbol-function 'popup-set-list)
               (lambda (_popup items) (setq rows items)))
              ((symbol-function 'popup-draw) #'ignore)
              ((symbol-function 'popup-delete) #'ignore)
              ((symbol-function 'read-event) (lambda (&rest _) ?\s)))
      (ac-php--popup-documentation document))
    ;; A narrower popup triggers popup-tip's second popup-fill-string call.
    (should (> initial-width width))
    rows))

(ert-deftest ac-php-documentation/tooltip-refill-preserves-header-colors-and-annotations ()
  (let* ((header (ac-php--format-tag-documentation
                  ["m" "getId(" "" "0:1" "int" "\\Service" "public" ""]))
         (elements '(("getId()" . font-lock-function-name-face)
                     ("int" . font-lock-type-face)
                     ("public" . font-lock-keyword-face)
                     ("\\Service" . font-lock-constant-face)))
         (document
          (ac-php--append-phpdoc
           header
           (concat (make-string 130 ?a) "\n@param int $value Identifier.\n@return int"))))
    (should (equal header "getId() → int · public · \\Service"))
    (should-not (string-match-p "\n" header))
    (dolist (element elements)
      (should (string-match (regexp-quote (car element)) header))
      (should (eq (get-text-property (match-beginning 0) 'face header) (cdr element))))
    (dolist (width '(80 40))
      (let ((rows (ac-php-test--documentation-popup-rows document width)))
        (should (equal (car rows) header))
        (dolist (element elements)
          (should (string-match (regexp-quote (car element)) (car rows)))
          (let ((face (get-text-property (match-beginning 0) 'face (car rows))))
            (should (equal (car face)
                           (list :background (face-background 'popup-tip-face nil t))))
            (should (memq (cdr element) (cdr face)))))
        (dolist (line '("@param int $value Identifier." "@return int"))
          (should (member line rows)))
        (should (member "" rows))
        (dolist (row rows)
          (should (<= (string-width row) width)))))))

(ert-deftest ac-php-documentation/tooltip-wraps-chinese-without-losing-content ()
  (let* ((description
          (mapconcat #'identity
                     (make-list 12 "这是一段用于验证提示窗口自动换行的中文说明。") ""))
         (document (concat "getId()\n\n" description "\n@return int")))
    (dolist (width '(80 40))
      (let ((rows (ac-php-test--documentation-popup-rows document width)))
        (should (equal (car rows) "getId()"))
        (should (equal (car (last rows)) "@return int"))
        (should (equal (replace-regexp-in-string "[ \n]" "" (mapconcat #'identity rows ""))
                       (replace-regexp-in-string "[ \n]" "" document)))
        (dolist (row rows)
          (should (<= (string-width row) width)))))))

(ert-deftest ac-php-documentation/display-drops-completion-properties-only ()
  (let* ((tags (make-hash-table :test #'equal))
         (candidate (propertize "getId()" 'ac-php-tags-data tags
                                'ac-php-help "$id" 'ac-php-return-type "int"
                                'face 'font-lock-function-name-face))
         (document (ac-php--append-phpdoc "getId()" "<code>int</code> value."))
         popup-text)
    (should (equal document "getId()\n\nint value."))
    (should-not (text-properties-at 0 document))
    (cl-letf (((symbol-function 'popup-tip)
               (lambda (text &rest _)
                 (setq popup-text text))))
      ;; The wrapper must also discard metadata from callers without PHPDoc.
      (ac-php--popup-documentation candidate))
    (should-not (get-text-property 0 'ac-php-tags-data popup-text))
    (should-not (get-text-property 0 'ac-php-help popup-text))
    (should-not (get-text-property 0 'ac-php-return-type popup-text))
    (let ((face (get-text-property 0 'face popup-text)))
      (should (equal (car face)
                     (list :background (face-background 'popup-tip-face nil t))))
      (should (memq 'font-lock-function-name-face (cdr face))))
    (should (eq (get-text-property 0 'ac-php-tags-data candidate) tags))
    (should (equal (get-text-property 0 'ac-php-help candidate) "$id"))
    (should (equal (get-text-property 0 'ac-php-return-type candidate) "int"))))

(defun ac-php-test--documentation-overlay-lines (document)
  "Render DOCUMENT with popup's real overlay string construction."
  (let (header-display body-display)
    (with-temp-buffer
      (insert "\n")
      (let* ((header-overlay (make-overlay (point-min) (point-min)))
             (body-overlay (make-overlay (point-min) (point-min)))
             (popup (make-popup :width 80
                                :overlays (vector header-overlay body-overlay))))
        (unwind-protect
            (cl-letf (((symbol-function 'popup-tip)
                       (lambda (text &rest _)
                         (let ((rows (cdr (popup-fill-string text nil 80))))
                           (popup-set-line-item popup 0 :item (car rows)
                                                :face 'popup-tip-face
                                                :summary ""
                                                :margin-left " " :margin-right " ")
                           (popup-set-line-item popup 1 :item (car (last rows))
                                                :face 'popup-tip-face
                                                :summary ""
                                                :margin-left " " :margin-right " ")
                           (setq header-display (overlay-get header-overlay 'display)
                                 body-display (overlay-get body-overlay 'display))))))
              (ac-php--popup-documentation document))
          (delete-overlay header-overlay)
          (delete-overlay body-overlay))))
    (list header-display body-display)))

(ert-deftest ac-php-documentation/tooltip-colored-text-uses-the-popup-background ()
  (dolist
      (example
       '((["m" "getId(" "" "0:1" "int" "\\Service" "public" ""]
          ("getId()" . font-lock-function-name-face)
          ("int" :foreground "#abcdef" :background "#000000")
          ("public" font-lock-keyword-face
           (:foreground "#987654" :background "#000000"))
          ("\\Service" . font-lock-constant-face))
         (["f" "\\fetch(" "$id" "0:1" "int"]
          ("\\fetch($id)" . font-lock-function-name-face)
          ("int" . font-lock-type-face))))
    (let* ((header (ac-php--format-tag-documentation (car example)))
           (elements (cdr example))
           (background (face-background 'popup-tip-face nil t)))
      ;; Include named, anonymous and composite faces, even ones with a dark
      ;; background of their own, as font-lock and themes can supply any form.
      (dolist (element elements)
        (should (string-match (regexp-quote (car element)) header))
        (put-text-property (match-beginning 0) (match-end 0) 'face (cdr element) header))
      (let* ((original-header (copy-sequence header))
             (document (ac-php--append-phpdoc header "Body text."))
             (display (ac-php-test--documentation-overlay-lines document))
             (header-display (car display))
             (body-display (nth 1 display)))
        (dolist (element elements)
          (should (string-match (regexp-quote (car element)) header-display))
          (let* ((face (get-text-property (match-beginning 0) 'face header-display))
                 (original (cdr element)))
            (should (equal (car face) (list :background background)))
            (should (equal (cdr face)
                           (if (and (listp original) (not (keywordp (car original))))
                               original
                             (list original))))))
        ;; The popup background must not leak into reusable headers or the
        ;; documentation displayed by company-mode, including its shadow faces.
        (should (equal-including-properties header original-header))
        (should (eq (get-text-property 0 'face header-display) 'popup-tip-face))
        (should (eq (get-text-property (1- (length header-display)) 'face header-display)
                    'popup-tip-face))
        (when (string-match "\\[user\\]" header-display)
          (should (eq (get-text-property (match-beginning 0) 'face header-display)
                      'popup-tip-face)))
        (should (string-match "Body text\\." body-display))
        (should (eq (get-text-property (match-beginning 0) 'face body-display)
                    'popup-tip-face))
        (should (eq (get-text-property 0 'face body-display) 'popup-tip-face))
        (should (eq (get-text-property (1- (length body-display)) 'face body-display)
                    'popup-tip-face))))))

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
