;;; ac-php-named-argument-test.el --- Named argument tests -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise PHP named argument completion and definition navigation.

;;; Code:

(require 'etags)

(defun ac-php-test--named-argument-tags ()
  "Build tags for named argument completion tests."
  (let* ((class-map (make-hash-table :test 'case-fold))
         (function-map (make-hash-table :test 'case-fold))
         (inherit-map (make-hash-table :test 'case-fold))
         (options "\\App\\RegisterOptions")
         (service "\\App\\Service")
         (base "\\App\\ServiceBase")
         (signature (concat "$user_unique_key_arr, $user_name, $user_visitor_id, "
                            "$introduction_code, $wx_unionid='', $other_data=[]")))
    (dolist (class (list options service base))
      (puthash class (vector "c" class "" "0:1" class) function-map)
      (puthash (concat class "(")
               (vector "f" (concat class "(")
                       (if (string= class options) signature "") "0:1" class)
               function-map))
    (puthash options
             (vector (vector "m" "__construct(" signature "0:1" "" options "public" ""))
             class-map)
    (puthash base
             (vector (vector "m" "configure(" "$first, $second, $third" "0:1"
                             "" base "public" "")
                     (vector "m" "options(" "" "0:1" options base "public" ""))
             class-map)
    (puthash service [] class-map)
    (puthash service (vector base) inherit-map)
    (dolist (function '("\\register(" "\\App\\register("))
      (puthash function
               (vector "f" function "$first, $second, $third" "0:1" "")
               function-map))
    (puthash "\\fallback(" ["f" "\\fallback(" "$value" "0:1" ""] function-map)
    (list class-map function-map inherit-map [] "/project/")))

(defun ac-php-test--named-argument-candidates (content &optional frontend)
  "Complete CONTENT at |CURSOR| using FRONTEND, returning plain candidates."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((tags (ac-php-test--named-argument-tags))
          (pos (point))
          (ac-php-prefix-str (company-ac-php--prefix-symbol)))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (prog1
            (mapcar #'substring-no-properties
                    (cond
                     ((eq frontend 'company) (company-ac-php-candidate ""))
                     ((eq frontend 'auto-complete)
                      (let ((ac-prefix (company-ac-php--prefix-symbol)))
                        (ac-php-candidate-ac)))
                     ((eq frontend 'core) (ac-php-candidate))
                     (t (ac-php-candidate-named-argument tags))))
          (should (= (point) pos)))))))

(ert-deftest ac-php-named-argument/constructor-prefix-and-resolution ()
  (dolist (call '("namespace App;\nnew RegisterOptions(user_|CURSOR|)"
                  "new \\App\\RegisterOptions(user_|CURSOR|)"
                  "namespace App;\nnew RegisterOptions(user_|CURSOR|"
                  "namespace App;\nuse App\\RegisterOptions as Options;\nnew Options(user_|CURSOR|)"
                  "use App\\RegisterOptions;\nnew RegisterOptions(user_|CURSOR|)"))
    (should (equal (ac-php-test--named-argument-candidates (concat "<?php\n" call))
                   '("user_unique_key_arr: " "user_name: " "user_visitor_id: ")))))

(ert-deftest ac-php-named-argument/register-options-example ()
  (should
   (equal
    (ac-php-test--named-argument-candidates
     "<?php
namespace App;
class Service {
    public function run() {
        $ctrl_ret = $this->do_register(new RegisterOptions(
            user_unique_key_arr: $condition,
            user_name: 'Apple user',
            user_visitor_id: $user_visitor_id,
            introduction_code: $introduction_code,
            wx_unionid: '',
            oth|CURSOR|
        ));
    }
}" 'core)
    '("other_data: "))))

(ert-deftest ac-php-named-argument/functions-and-empty-prefix ()
  (dolist (call '("register(|CURSOR|)" "register(|CURSOR|"
                  "\\register(|CURSOR|)" "namespace App;\nregister(|CURSOR|)"
                  "\\App\\register(|CURSOR|)"))
    (should (equal (ac-php-test--named-argument-candidates (concat "<?php\n" call))
                   '("first: " "second: " "third: ")))))

(ert-deftest ac-php-named-argument/methods-and-inheritance ()
  (dolist (receiver '("$this" "self" "static" "parent"))
    (should
     (equal
      (ac-php-test--named-argument-candidates
       (concat "<?php\nnamespace App;\nclass Service extends ServiceBase {\n"
               "    public function run() {\n        " receiver
               (if (string= receiver "$this") "->" "::")
               "configure(sec|CURSOR|);\n    }\n}"))
      '("second: "))))
  (dolist (operator '("->" "?->" "::"))
    (should
     (equal
      (ac-php-test--named-argument-candidates
       (concat "<?php\nfunction run(\\App\\Service $service) {\n"
               "$service" operator "configure(th|CURSOR|);\n}"))
      '("third: ")))))

(ert-deftest ac-php-named-argument/chained-method-and-new-receiver ()
  (dolist (call '("(new \\App\\Service())->configure(sec|CURSOR|)"
                  "(new \\App\\Service())->options()->__construct(user_n|CURSOR|)"))
    (should
     (equal (ac-php-test--named-argument-candidates (concat "<?php\n" call))
            (if (string-match-p "options" call)
                '("user_name: ") '("second: "))))))

(ert-deftest ac-php-named-argument/inherited-constructor-fallback ()
  (dolist (class-name '("Service" "self" "static" "parent"))
    (with-ac-php-buffer-test
        (concat "<?php\nnamespace App;\nclass Service extends ServiceBase {\n"
                "    public function run() {\n        new " class-name
                "(sec|CURSOR|);\n    }\n}")
      (search-forward "|CURSOR|")
      (replace-match "" t t)
      (let* ((tags (ac-php-test--named-argument-tags))
             (class-map (ac-php-g--class-map tags))
             (function-map (ac-php-g--function-map tags)))
        (remhash "\\App\\Service(" function-map)
        (remhash "\\App\\ServiceBase(" function-map)
        (puthash "\\App\\ServiceBase"
                 [["m" "__construct(" "$first, $second" "0:1" ""
                   "\\App\\ServiceBase" "public" ""]]
                 class-map)
        (should
         (equal (mapcar #'substring-no-properties
                        (ac-php-candidate-named-argument tags))
                '("second: ")))))))

(ert-deftest ac-php-named-argument/excludes-used-names-before-and-after-point ()
  (should
   (equal (ac-php-test--named-argument-candidates
           "<?php\nregister(third: 3, |CURSOR|, first: 1)")
          '("second: ")))
  (should
   (equal (ac-php-test--named-argument-candidates
           "<?php\nregister(1, |CURSOR|, third: 3)")
          '("second: "))))

(ert-deftest ac-php-named-argument/commas-in-nested-expressions-and-comments ()
  (dolist (first '("[1, 2, [3, 4]]" "array(1, 2)" "nested(1, 2)"
                   "'comma, first: fake'" "\"escaped \\\", second: fake\""
                   "function () { return [1, 2]; }" "Service::VALUE"))
    (should
     (equal
      (ac-php-test--named-argument-candidates
       (concat "<?php\nregister(" first
               " /* , ignored */ , // , first: ignored\n sec|CURSOR|)"))
      '("second: ")))))

(ert-deftest ac-php-named-argument/multiline-callable-with-comments ()
  (dolist (call '("register /* ignored */\n (sec|CURSOR|)"
                  "namespace App;\nnew /* ignored */ RegisterOptions\n (user_n|CURSOR|)"
                  "(new \\App\\Service())\n -> configure /* ignored */\n (sec|CURSOR|)"))
    (should
     (equal (ac-php-test--named-argument-candidates (concat "<?php\n" call))
            (if (string-match-p "RegisterOptions" call)
                '("user_name: ") '("second: "))))))

(ert-deftest ac-php-named-argument/does-not-duplicate-existing-colon ()
  (should
   (equal (ac-php-test--named-argument-candidates
           "<?php\nregister(sec|CURSOR|: 2)")
          '("second"))))

(ert-deftest ac-php-named-argument/ignores-values-and-non-call-contexts ()
  (dolist (call '("register(first: sec|CURSOR|)" "register($sec|CURSOR|)"
                  "register('sec|CURSOR|')" "register(\"sec|CURSOR|\")"
                  "register(/* sec|CURSOR| */)" "register(// sec|CURSOR|\n)"
                  "register([sec|CURSOR|])" "register((sec|CURSOR|))"
                  "register(1 + sec|CURSOR|)" "$register(sec|CURSOR|)"
                  "function register(sec|CURSOR|) {}"
                  "function &register(sec|CURSOR|) {}"
                  "if (sec|CURSOR|) {}" "unknown(sec|CURSOR|)"
                  "register(unknown(sec|CURSOR|))" "sec|CURSOR|"))
    (should-not (ac-php-test--named-argument-candidates (concat "<?php\n" call)))))

(ert-deftest ac-php-named-argument/signatures-preserve-defaults-and-modifiers ()
  (with-ac-php-buffer-test "<?php\n"
    (should
     (equal
      (ac-php--signature-parameters
       (concat "array $first=['a,b', '$fake', [1, 2]], "
               "?string &$second=\"escaped \\\", $fake\", "
               "public readonly Options $third=null, ...$rest"))
      '(("first" . "array $first=['a,b', '$fake', [1, 2]]")
        ("second" . "?string &$second=\"escaped \\\", $fake\"")
        ("third" . "public readonly Options $third=null")
        ("rest" . "...$rest"))))))

(ert-deftest ac-php-named-argument/frontends-use-core-candidates ()
  (dolist (frontend '(core company auto-complete))
    (should (member "second: "
                    (ac-php-test--named-argument-candidates
                     "<?php\nregister(sec|CURSOR|)" frontend)))
    (should (member "fallback("
                    (ac-php-test--named-argument-candidates
                     "<?php\nregister(fall|CURSOR|)" frontend)))))

(ert-deftest ac-php-named-argument/candidate-metadata ()
  (with-ac-php-buffer-test "<?php\nregister(sec"
    (goto-char (point-max))
    (let ((candidate (car (ac-php-candidate-named-argument
                          (ac-php-test--named-argument-tags)))))
      (should (equal candidate "second: "))
      (should (equal (get-text-property 0 'ac-php-help candidate) "$second"))
      (should (equal (get-text-property 0 'ac-php-tag-type candidate) "v"))
      (should-not (ac-php--tag-name-is-function candidate)))))

(defun ac-php-test--named-argument-definition-tags ()
  "Build tags pointing at the named argument definitions fixture."
  (let* ((tags (ac-php-test--named-argument-tags))
         (file (expand-file-name "named-argument-definitions.php"
                                 ac-php-test-fixtures-dir))
         (function-map (ac-php-g--function-map tags))
         (class-map (ac-php-g--class-map tags)))
    (setf (nth 3 tags) (vector file))
    (with-ac-php-file-test "named-argument-definitions.php"
      (dolist (entry (list (list (gethash "\\App\\RegisterOptions(" function-map)
                                "class RegisterOptions" "__construct(")
                          (list (aref (gethash "\\App\\RegisterOptions" class-map) 0)
                                "class RegisterOptions" "__construct(")
                          (list (aref (gethash "\\App\\ServiceBase" class-map) 0)
                                "class ServiceBase" "configure(")
                          (list (gethash "\\App\\register(" function-map)
                                "function &register" "(")))
        (goto-char (point-min))
        (search-forward (nth 1 entry))
        (search-forward (nth 2 entry))
        (aset (car entry) 3 (format "0:%d" (line-number-at-pos))))
      (goto-char (point-min))
      (search-forward "class ServiceBase")
      (search-forward "__construct(")
      (let ((location (format "0:%d" (line-number-at-pos))))
        (puthash "\\App\\ServiceBase"
                 (vconcat (gethash "\\App\\ServiceBase" class-map)
                          (vector (vector "m" "__construct(" "$first, $second"
                                          location "" "\\App\\ServiceBase" "public" "")))
                 class-map)
        (dolist (class '("\\App\\Service" "\\App\\ServiceBase"))
          (let ((constructor (gethash (concat class "(") function-map)))
            (aset constructor 2 "$first, $second")
            (aset constructor 3 location)))))
    tags))

(defun ac-php-test--jump-to-named-argument (content name)
  "Jump from |CURSOR| in CONTENT to parameter NAME and back."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let* ((tags (ac-php-test--named-argument-definition-tags))
           (file (aref (ac-php-g--file-list tags) 0))
           (existing-buffer (find-buffer-visiting file))
           (source-buffer (current-buffer))
           (source-pos (point))
           (source-location (ac-php-current-location))
           (ac-php-location-stack nil)
           (ac-php-location-stack-index 0))
      (unwind-protect
          (save-window-excursion
            (switch-to-buffer source-buffer)
            (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
              (ac-php-find-symbol-at-point)
              (should (equal (buffer-file-name) file))
              (should (looking-at (concat "\\$" (regexp-quote name) "\\_>")))
              (should (equal (car ac-php-location-stack) source-location))
              (ac-php-location-stack-back)
              (should (eq (current-buffer) source-buffer))
              (should (= (point) source-pos))))
        (unless existing-buffer
          (let ((definition-buffer (find-buffer-visiting file)))
            (when definition-buffer (kill-buffer definition-buffer))))))))

(ert-deftest ac-php-named-argument/jump-register-options-example ()
  (dolist (name '("user_unique_key_arr" "user_name" "user_visitor_id"
                  "introduction_code" "wx_unionid" "other_data"))
    (ac-php-test--jump-to-named-argument
     (concat "<?php\nnamespace App;\nclass Service {\n"
             "    public function run() {\n"
             "        $ctrl_ret = $this->do_register(new RegisterOptions(\n"
             "            |CURSOR|" name ": $value,\n"
             "        ));\n    }\n}")
     name)))

(ert-deftest ac-php-named-argument/jump-from-any-position-in-label ()
  (dolist (label '("|CURSOR|user_name" "user_|CURSOR|name" "user_name|CURSOR|"))
    (ac-php-test--jump-to-named-argument
     (concat "<?php\nuse App\\RegisterOptions as Options;\nnew Options("
             label " /* label comment */ : 'Apple user')")
     "user_name")))

(ert-deftest ac-php-named-argument/jump-functions-methods-and-inheritance ()
  (dolist (call '("\\App\\register(first: [1, 2], sec|CURSOR|ond: null)"
                  "(new \\App\\Service())->configure(sec|CURSOR|ond: null)"
                  "namespace App;\nclass Service extends ServiceBase {\n    public function run() {\n$this->configure(sec|CURSOR|ond: null);\n}\n}"
                  "namespace App;\nService::configure(sec|CURSOR|ond: null)"
                  "namespace App;\nclass Service extends ServiceBase {\n    public function run() {\nparent::configure(sec|CURSOR|ond: null);\n}\n}"
                  "namespace App;\nnew Service(sec|CURSOR|ond: null)"
                  "namespace App;\nclass Service extends ServiceBase {\n    public function run() {\nnew parent(sec|CURSOR|ond: null);\n}\n}"))
    (ac-php-test--jump-to-named-argument (concat "<?php\n" call) "second"))
  (ac-php-test--jump-to-named-argument
   "<?php\n\\App\\register(th|CURSOR|ird: null)" "third"))

(ert-deftest ac-php-named-argument/jump-recognition-excludes-other-symbols ()
  (dolist (call '("namespace App;\nregister(first: sec|CURSOR|ond)"
                  "namespace App;\nregister(first: $sec|CURSOR|ond)"
                  "namespace App;\nregister('sec|CURSOR|ond: text')"
                  "namespace App;\nregister(/* sec|CURSOR|ond: text */)"
                  "namespace App;\nregister(sec|CURSOR|ond::VALUE)"
                  "namespace App;\nregister(unknown|CURSOR|: null)"
                  "namespace App;\nregister(Sec|CURSOR|ond: null)"
                  "namespace App;\nregister(unknown(sec|CURSOR|ond: null))"
                  "namespace App;\nregister([sec|CURSOR|ond: null])"
                  "namespace App;\nregister(sec|CURSOR|ond)"
                  "sec|CURSOR|ond: null;"))
    (with-ac-php-buffer-test (concat "<?php\n" call)
      (search-forward "|CURSOR|")
      (replace-match "" t t)
      (let ((pos (point)))
        (should-not (ac-php--named-argument-symbol (ac-php-test--named-argument-tags)))
        (should (= (point) pos))))))

(ert-deftest ac-php-named-argument/definition-search-is-signature-only ()
  (with-ac-php-file-test "named-argument-definitions.php"
    (search-forward "function &register")
    (beginning-of-line)
    (let* ((start (point))
           (second (ac-php--parameter-definition-position "second")))
      (should second)
      (should (= (point) start))
      (goto-char second)
      (should (looking-at "\\$second = null"))
      (goto-char start)
      (should-not (ac-php--parameter-definition-position "missing")))
    (search-forward "function shadowed")
    (beginning-of-line)
    (should-not (ac-php--parameter-definition-position "second"))))

(ert-deftest ac-php-named-argument/definition-search-handles-signature-layouts ()
  (dolist (declaration '("function register($first, $second) {}"
                         "function\nregister\n(\n$first,\n$second\n) {}"
                         "function /* comment */ &\nregister /* comment */\n($first, $second) {}"))
    (with-ac-php-buffer-test (concat "<?php\n" declaration)
      (search-forward "register")
      (beginning-of-line)
      (let ((position (ac-php--parameter-definition-position "second")))
        (should position)
        (goto-char position)
        (should (looking-at "\\$second"))))))

(provide 'ac-php-named-argument-test)
;;; ac-php-named-argument-test.el ends here
