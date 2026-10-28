;;; ac-php-return-array-test.el --- Return array completion tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPDoc return array contexts, including nested map and list values.

;;; Code:

(defun ac-php-test--return-array-context (body &optional type)
  "Return completion context in method BODY annotated with TYPE."
  (with-ac-php-buffer-test
      (concat "<?php\nclass Config {\n"
              "/** @return " (or type "Overrides") " */\n"
              "protected static function get_overrides(): array {\n"
              body "\n}\n}")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((pos (point)))
      (prog1 (ac-php--array-key-context)
        (should (= pos (point)))))))

(ert-deftest ac-php-return-array/root-uses-enclosing-return-type ()
  (let ((context
         (ac-php-test--return-array-context
          "return ['title' => 'MQTT', 'ca|CURSOR|' => []];")))
    (should (equal (plist-get context :return-type) "Overrides"))
    (should (equal (plist-get context :prefix) "ca"))
    (should (equal (plist-get context :used-keys) '("title")))
    (should-not (plist-get context :path))))

(ert-deftest ac-php-return-array/nested-shape-uses-key-path ()
  (let ((context
         (ac-php-test--return-array-context
          "return ['capabilities' => ['enable' => true, '|CURSOR|']];")))
    (should (equal (plist-get context :return-type) "Overrides"))
    (should (equal (plist-get context :path) '("capabilities")))
    (should (equal (plist-get context :used-keys) '("enable")))))

(ert-deftest ac-php-return-array/map-value-retains-string-key-path ()
  (let ((context
         (ac-php-test--return-array-context
          (concat "return ['fields' => [\n"
                  "  'host' => ['batch_edit' => true],\n"
                  "  'subscription_qos' => ['min' => 0, '|CURSOR|']\n"
                  "]];"))))
    (should (equal (plist-get context :path)
                   '("fields" "subscription_qos")))
    (should (equal (plist-get context :used-keys) '("min")))))

(ert-deftest ac-php-return-array/list-elements-use-index-path ()
  (dolist (entry '("[" "2 => ["))
    (let* ((context
            (ac-php-test--return-array-context
             (concat "return ['actions' => [" entry "'|CURSOR|']]];")))
           (path (plist-get context :path)))
      (should (equal (car path) "actions"))
      (should (eq (car (cadr path)) :index)))))

(ert-deftest ac-php-return-array/dynamic-map-key-uses-element-path ()
  (let* ((context
          (ac-php-test--return-array-context
           "return ['fields' => [$name => ['|CURSOR|']]];"))
         (path (plist-get context :path)))
    (should (equal path '("fields" (:index))))))

(ert-deftest ac-php-return-array/comments-and-incomplete-array ()
  (let ((context
         (ac-php-test--return-array-context
          "return /* config */ ['fields' => [/* field */ 'host' => ['|CURSOR|")))
    (should (equal (plist-get context :return-type) "Overrides"))
    (should (equal (plist-get context :path) '("fields" "host")))))

(ert-deftest ac-php-return-array/only-key-slots-trigger ()
  (dolist (body '("return ['title' => '|CURSOR|'];"
                  "return ['fields' => ['host' => ['label' => '|CURSOR|']]];"
                  "$config = ['|CURSOR|'];\nreturn $config;"
                  "return ['fields' => transform(['|CURSOR|'])];"))
    (let ((context (ac-php-test--return-array-context body)))
      (should-not (plist-get context :return-type)))))

(ert-deftest ac-php-return-array/selects-current-method-doc ()
  (with-ac-php-buffer-test
      (concat "<?php\nclass Config {\n"
              "/** @return array{old: int} */\n"
              "function first() { return []; }\n"
              "/** @return array{current: bool} */\n"
              "function second() { return ['|CURSOR|']; }\n}")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (should (equal (plist-get (ac-php--array-key-context) :return-type)
                   "array{current: bool}"))))

(ert-deftest ac-php-return-array/anonymous-function-keeps-own-return-scope ()
  (should-not
   (plist-get
    (ac-php-test--return-array-context
     "$callback = function () { return ['|CURSOR|']; };")
    :return-type))
  (let ((context
         (ac-php-test--return-array-context
          (concat "/** @return array{closure_key: int} */\n"
                  "$callback = function () { return ['|CURSOR|']; };"))))
    (should (equal (plist-get context :return-type)
                   "array{closure_key: int}")))
  (let ((context
         (ac-php-test--return-array-context
          (concat "$callback = function () { return []; };\n"
                  "return ['|CURSOR|'];"))))
    (should (equal (plist-get context :return-type) "Overrides"))))

(defun ac-php-test--return-array-candidates (body frontend)
  "Complete return array BODY using FRONTEND and local PHPStan aliases."
  (with-ac-php-buffer-test
      (concat "<?php\n/**\n"
              " * @phpstan-type Field array{label?: string, batch_edit?: bool, "
              "form?: array{field_type?: string}}\n"
              " * @phpstan-type Overrides array{title?: string, "
              "fields?: array<string, Field|null>, "
              "actions?: list<array{key: string, label: string}>}\n"
              " */\nclass Config {\n"
              "/** @return Overrides */\n"
              "protected static function get_overrides(): array {\n"
              body "\n}\n}")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((tags (list (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      (make-hash-table :test #'equal)
                      [] "/project/")))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (mapcar
         #'substring-no-properties
         (cond
          ((eq frontend 'company) (company-ac-php-candidate ""))
          ((eq frontend 'auto-complete)
           (let ((ac-prefix (company-ac-php--prefix-symbol)))
             (ac-php-candidate-ac)))
          (t (ac-php-candidate))))))))

(ert-deftest ac-php-return-array/root-completes-unused-keys-in-all-frontends ()
  (dolist (frontend '(core company auto-complete))
    (should
     (equal (ac-php-test--return-array-candidates
             "return ['title' => 'MQTT', '|CURSOR|'];" frontend)
            '("fields" "actions")))))

(ert-deftest ac-php-return-array/nested-map-and-list-complete-in-all-frontends ()
  (dolist (example
           '(("return ['fields' => ['host' => ['|CURSOR|']]];"
              "label" "batch_edit" "form")
             ("return ['fields' => [$name => ['|CURSOR|']]];"
              "label" "batch_edit" "form")
             ("return ['fields' => ['host' => ['form' => ['|CURSOR|']]]];"
              "field_type")
             ("return ['actions' => [['|CURSOR|']]];" "key" "label")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--return-array-candidates (car example) frontend)
              (cdr example))))))

(provide 'ac-php-return-array-test)
;;; ac-php-return-array-test.el ends here
