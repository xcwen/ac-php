;;; ac-php-literal-test.el --- Literal argument completion tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHPDoc string literal and method template completion.

;;; Code:

(defun ac-php-test--literal-candidates (content &optional frontend tags-data)
  "Complete CONTENT at |CURSOR| using FRONTEND and TAGS-DATA."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((tags (or tags-data
                    (list (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal)
                          (make-hash-table :test #'equal)
                          [] "/project/")))
          (pos (point)))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (prog1
            (mapcar
             #'substring-no-properties
             (cond
              ((eq frontend 'company) (company-ac-php-candidate ""))
              ((eq frontend 'auto-complete)
               (let ((ac-prefix (company-ac-php--prefix-symbol)))
                 (ac-php-candidate-ac)))
              (t (ac-php-candidate))))
          (should (= (point) pos)))))))

(defconst ac-php-test--generic-field-method
  (concat
   " * @method array{user_id: int, tenant_id: int, wx_openid: string|null}"
   "[TFieldName]|TDefault "
   "field_get_value<TFieldName of "
   "'user_id'|'tenant_id'|'wx_openid', TDefault>"
   "($user_id, TFieldName $field_name, TDefault $default_value = 0)\n"))

(defun ac-php-test--generic-field-content (call)
  "Return a PHP buffer containing the generic field method and CALL."
  (concat
   "<?php\n/**\n" ac-php-test--generic-field-method
   " */\nclass Test {\npublic function run() {\n  " call "\n}\n}"))

(ert-deftest ac-php-literal/generic-method-completes-field-name ()
  (let ((content
         (ac-php-test--generic-field-content
          "$this->field_get_value(1, \"|CURSOR|\");")))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal (ac-php-test--literal-candidates content frontend)
              '("user_id" "tenant_id" "wx_openid"))))))

(ert-deftest ac-php-literal/context-prefix-and-metadata ()
  (with-ac-php-buffer-test
      (ac-php-test--generic-field-content
       "$this->field_get_value(1, 'wx_|CURSOR|');")
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let* ((context (ac-php--string-literal-argument-context))
           (tags (list (make-hash-table :test #'equal)
                       (make-hash-table :test #'equal)
                       (make-hash-table :test #'equal)
                       [] "/project/"))
           (candidate (car (ac-php-candidate-string-literal tags context))))
      (should (equal (plist-get context :callable) "field_get_value"))
      (should (= (plist-get context :argument-index) 1))
      (should (equal (plist-get context :prefix) "wx_"))
      (should (equal (company-ac-php--prefix) '("wx_" . t)))
      (should (equal (substring-no-properties candidate) "user_id"))
      (should (equal (get-text-property 0 'ac-php-return-type candidate)
                     "TFieldName")))))

(ert-deftest ac-php-literal/only-completes-constrained-argument ()
  (should-not
   (ac-php-test--literal-candidates
    (ac-php-test--generic-field-content
     "$this->field_get_value(\"|CURSOR|\", \"user_id\");"))))

(ert-deftest ac-php-literal/direct-phpdoc-union-completes ()
  (let ((content
         (concat
          "<?php\nclass Test {\n"
          "/** @param 'draft'|'ready' $status */\n"
          "private function set_status($status) {}\n"
          "public function run() { $this->set_status(\"|CURSOR|\"); }\n}")))
    (should
     (equal (ac-php-test--literal-candidates content)
            '("draft" "ready")))))

(ert-deftest ac-php-literal/indexed-method-reads-template-from-source ()
  (let* ((source
          (make-temp-file "ac-php-literal-" nil ".php"
                          (concat "<?php\n/**\n"
                                  ac-php-test--generic-field-method
                                  " */\nclass BUser {}\n")))
         (class "\\Gen\\Models\\BUser")
         (class-map (make-hash-table :test #'equal))
         (function-map (make-hash-table :test #'equal))
         (inherit-map (make-hash-table :test #'equal))
         (member
          (vector
           "m" "field_get_value("
           "$user_id, $field_name, $default_value=0"
           "0:3" "\\Gen\\Models\\TDefault" class "public" ""
           (concat "$user_id, unknown-ref(Gen\\Models\\TFieldName) "
                   "$field_name, unknown-ref(Gen\\Models\\TDefault) "
                   "$default_value")))
         (tags (list class-map function-map inherit-map (vector source)
                     "/project/"))
         (content
          (concat "<?php\nfunction run(" class " $user) {\n"
                  "  $user->field_get_value(1, \"|CURSOR|\");\n}")))
    (unwind-protect
        (progn
          (puthash class (vector member) class-map)
          (puthash class (vector "c" class "" "0:1" class) function-map)
          (should
           (equal (ac-php-test--literal-candidates content 'core tags)
                  '("user_id" "tenant_id" "wx_openid"))))
      (delete-file source))))

(provide 'ac-php-literal-test)
;;; ac-php-literal-test.el ends here
