;;; ac-php-hierarchy-test.el --- Inheritance browsing tests -*- lexical-binding: t; -*-

;;; Code:

(defun ac-php-test--with-hierarchy (function)
  "Call FUNCTION with a temporary PHP source and its indexed hierarchy."
  (let* ((directory (make-temp-file "ac-php-hierarchy-" t))
         (file (expand-file-name "Classes.php" directory))
         (tags (list (make-hash-table :test 'case-fold)
                     (make-hash-table :test 'case-fold)
                     (make-hash-table :test 'case-fold)
                     ["Classes.php"] directory)))
    (unwind-protect
        (save-window-excursion
          (with-temp-file file
            (insert "<?php\nnamespace App;\n"
                    "class Base {\npublic $state;\npublic function approved() {}\n}\n"
                    "abstract class Adapter extends Base {\npublic const FLOW_TYPE = 0;\n"
                    "abstract protected function prepare_business(): array;\n}\n"
                    "class Child extends Adapter {\npublic const FLOW_TYPE = 1;\n"
                    "public function prepare_business(): array { return []; }\n}\n"
                    "class Grandchild extends Child {}\nclass Other {}\n"))
          (switch-to-buffer (find-file-noselect file))
          (php-mode)
          (dolist (name '("Base" "Adapter" "Child" "Grandchild" "Other"))
            (goto-char (point-min))
            (search-forward (concat "class " name))
            (puthash (concat "\\App\\" name)
                     (vector "c" (concat "\\App\\" name) ""
                             (format "0:%d" (line-number-at-pos)) (concat "\\App\\" name))
                     (ac-php-g--function-map tags))
            (puthash (concat "\\App\\" name) [] (ac-php-g--class-map tags)))
          (puthash "\\App\\Base"
                   [["p" "state" "" "0:4" "string" "\\App\\Base" "public" ""]
                    ["m" "approved(" "" "0:5" "void" "\\App\\Base" "public" ""]]
                   (ac-php-g--class-map tags))
          (puthash "\\App\\Adapter"
                   [["d" "FLOW_TYPE" "" "0:8" "int" "\\App\\Adapter" "public" "static"]
                    ["m" "prepare_business(" "" "0:9" "array" "\\App\\Adapter" "protected" ""]]
                   (ac-php-g--class-map tags))
          (puthash "\\App\\Child"
                   [["d" "FLOW_TYPE" "" "0:12" "int" "\\App\\Child" "public" "static"]
                    ["m" "prepare_business(" "" "0:13" "array" "\\App\\Child" "public" ""]]
                   (ac-php-g--class-map tags))
          (puthash "\\App\\Adapter" ["Base"] (ac-php-g--inherit-map tags))
          (puthash "\\App\\Child" ["\\App\\Adapter"] (ac-php-g--inherit-map tags))
          (puthash "\\App\\Grandchild" ["Child"] (ac-php-g--inherit-map tags))
          (goto-char (point-min))
          (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
            (funcall function tags)))
      (when (get-buffer "*ac-php hierarchy*") (kill-buffer "*ac-php hierarchy*"))
      (when (get-file-buffer file) (kill-buffer (get-file-buffer file)))
      (delete-directory directory t))))

(ert-deftest ac-php-hierarchy/transitive-relations-and-cycles ()
  (ac-php-test--with-hierarchy
   (lambda (tags)
     (should (equal (ac-php--hierarchy-relations "\\app\\adapter" tags)
                    '("\\App\\Adapter" ("\\App\\Base") ("\\App\\Child" "\\App\\Grandchild"))))
     (puthash "\\App\\Base" ["Grandchild"] (ac-php-g--inherit-map tags))
     (let ((relations (ac-php--hierarchy-relations "\\App\\Adapter" tags)))
       (should (= 3 (length (nth 1 relations))))
       (should (= 3 (length (nth 2 relations))))))))

(ert-deftest ac-php-hierarchy/recognizes-declarations-and-inherited-receiver ()
  (ac-php-test--with-hierarchy
   (lambda (tags)
     (dolist (example '(("class Adapter" "\\App\\Adapter" nil)
                        ("const FLOW_TYPE" "\\App\\Adapter" "FLOW_TYPE")
                        ("function prepare_business" "\\App\\Adapter" "prepare_business(")
                        ("$state" "\\App\\Base" "state")))
       (goto-char (point-min))
       (search-forward (car example))
       (let* ((position (point)) (context (ac-php--hierarchy-context tags)))
         (should (equal (car context) (nth 1 example)))
         (should (equal (and (cadr context) (aref (cadr context) 1)) (nth 2 example)))
         (should (= position (point)))))
     (goto-char (point-max))
     (insert "\nfunction inspect(\\App\\Child $adapter) { $adapter->approved(); }")
     (search-backward "approved")
     (forward-char 4)
     (should (equal (car (ac-php--hierarchy-context tags)) "\\App\\Child"))
     (set-buffer-modified-p nil))))

(ert-deftest ac-php-hierarchy/member-list-and-navigation ()
  (ac-php-test--with-hierarchy
   (lambda (_tags)
     (search-forward "function prepare_business")
     (let ((origin (point)) (source (current-buffer))
           (ac-php-location-stack nil) (ac-php-location-stack-index 0))
       (ac-php-show-hierarchy)
       (should (derived-mode-p 'ac-php-hierarchy-mode))
       (should buffer-read-only)
       (should (string-match-p "Child classes" (buffer-string)))
       (should-not (string-match-p "FLOW_TYPE" (buffer-string)))
       (goto-char (point-min))
       (search-forward "\\App\\Child\n")
       (search-forward "prepare_business(")
       (push-button (1- (point)))
       (should (eq (current-buffer) source))
       (should (= (line-number-at-pos) 13))
       (ac-php-location-stack-back)
       (should (eq (current-buffer) source))
       (should (= origin (point)))
       (ac-php-show-hierarchy t)
       (should (string-match-p "FLOW_TYPE" (buffer-string)))
       (should (string-match-p "approved(" (buffer-string)))))))

(ert-deftest ac-php-hierarchy/rejects-missing-tags-and-standalone-functions ()
  (with-ac-php-buffer-test "<?php function run() {}"
    (search-forward "run")
    (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () nil)))
      (should-error (ac-php-show-hierarchy) :type 'user-error)))
  (ac-php-test--with-hierarchy
   (lambda (tags)
     (goto-char (point-max))
     (insert "\nfunction standalone() {}")
     (search-backward "standalone")
     (puthash "\\App\\standalone(" ["f" "\\App\\standalone(" "" "0:17" "void"]
              (ac-php-g--function-map tags))
     (should-error (ac-php-show-hierarchy) :type 'user-error)
     (set-buffer-modified-p nil))))

(provide 'ac-php-hierarchy-test)
;;; ac-php-hierarchy-test.el ends here
