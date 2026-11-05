;;; ac-php-documentation-frontends-test.el --- Completion documentation -*- lexical-binding: t; -*-

;;; Commentary:

;; Exercise lazy PHPDoc display through both completion frontends.

;;; Code:

(defconst ac-php-test--documentation-frontend-source
  "<?php
namespace Demo;
/**
 * Look up one item.
 *
 * @param int $id Item identifier.
 * @return string Item label.
 */
function lookup($id) {}
/** Widget services. */
class Widget {
    /**
     * Fetch a label.
     * @param int $id Item identifier.
     * @return string Label.
     */
    public function fetch($id) {}
    /** Current name. */
    public string $name;
}
")

(defun ac-php-test--with-documentation-frontends (function)
  "Call FUNCTION with tags for a temporary PHP source file."
  (let* ((file (make-temp-file "ac-php-doc-frontends-" nil ".php"
                               ac-php-test--documentation-frontend-source))
         (class-map (make-hash-table :test #'equal))
         (function-map (make-hash-table :test #'equal))
         (tags (list class-map function-map (make-hash-table :test #'equal)
                     (vector file) (file-name-directory file)))
         (ac-php--source-buffers (make-hash-table :test #'equal)))
    (unwind-protect
        (progn
          (puthash "\\Demo\\lookup("
                   ["f" "\\Demo\\lookup(" "$id" "0:9" "string"] function-map)
          (puthash "\\Demo\\Widget"
                   ["c" "\\Demo\\Widget" "" "0:11" "\\Demo\\Widget"] function-map)
          (puthash "\\Demo\\Widget"
                   [["m" "fetch(" "$id" "0:17" "string" "\\Demo\\Widget" "public" ""]
                    ["p" "name" "" "0:19" "string" "\\Demo\\Widget" "public" ""]]
                   class-map)
          (funcall function tags))
      (maphash (lambda (_ entry)
                 (when (buffer-live-p (cdr entry)) (kill-buffer (cdr entry))))
               ac-php--source-buffers)
      (delete-file file))))

(defun ac-php-test--documentation-frontend-candidate (tags content frontend name)
  "Complete CONTENT with TAGS using FRONTEND and return candidate NAME."
  (with-ac-php-buffer-test content
    (search-forward "|CURSOR|")
    (replace-match "" t t)
    (let ((pos (point)) (ac-php-prefix-str ""))
      (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () tags)))
        (let* ((candidates
                (if (eq frontend 'company)
                    (company-ac-php-candidate "")
                  (let ((ac-prefix (company-ac-php--prefix-symbol)))
                    (ac-php-candidate-ac))))
               (candidate (cl-find name candidates :test #'string=)))
          (should candidate)
          (should (= pos (point)))
          candidate)))))

(defun ac-php-test--documentation-frontend-text (candidate frontend)
  "Request CANDIDATE's documentation through FRONTEND."
  (if (eq frontend 'company)
      (with-current-buffer (company-ac-php-backend 'doc-buffer candidate)
        (buffer-string))
    (ac-php-document candidate)))

(ert-deftest ac-php-documentation-frontends/functions-load-docs-on-demand ()
  (ac-php-test--with-documentation-frontends
   (lambda (tags)
     (dolist (frontend '(auto-complete company))
       (let ((read-source (symbol-function 'ac-php--call-with-source))
             (reads 0) candidate)
         (cl-letf (((symbol-function 'ac-php--call-with-source)
                    (lambda (&rest args)
                      (setq reads (1+ reads))
                      (apply read-source args))))
           (setq candidate
                 (ac-php-test--documentation-frontend-candidate
                  tags "<?php\nnamespace Demo;\nlook|CURSOR|" frontend "lookup("))
           (should (= reads 0))
           (should (eq (get-text-property 0 'ac-php-tags-data candidate) tags))
           (should (equal (get-text-property 0 'ac-php-help candidate) "$id"))
           (should (equal (get-text-property 0 'ac-php-return-type candidate) "string"))
           (let ((doc (ac-php-test--documentation-frontend-text candidate frontend)))
             (should (> reads 0))
             (should (equal (car (split-string doc "\n"))
                            "[user] lookup($id) → string"))
             (should (string-match-p "lookup(\\$id)" doc))
             (should (string-match-p "Look up one item\\." doc))
             (should (string-match-p "@param int \\$id Item identifier\\." doc))
             (should (string-match-p "@return string Item label\\." doc))
             (should-not (string-match-p "/\\*\\*" doc)))))))))

(ert-deftest ac-php-documentation-frontends/members-keep-docs-and-metadata ()
  (ac-php-test--with-documentation-frontends
   (lambda (tags)
     (dolist (frontend '(auto-complete company))
       (dolist (entry '(("fe" "fetch(" "Fetch a label." "$id")
                        ("na" "name" "Current name." "")))
         (let* ((candidate
                 (ac-php-test--documentation-frontend-candidate
                  tags
                  (concat "<?php\nfunction run(\\Demo\\Widget $widget) {\n$widget->"
                          (car entry) "|CURSOR|;\n}")
                  frontend (nth 1 entry)))
                (doc (ac-php-test--documentation-frontend-text candidate frontend)))
           (should (string-match-p (regexp-quote (nth 2 entry)) doc))
           (should (equal (car (split-string doc "\n"))
                          (concat (if (equal (nth 1 entry) "fetch(")
                                      "fetch($id)" "name")
                                  " → string · public · \\Demo\\Widget")))
           (should (equal (get-text-property 0 'ac-php-help candidate) (nth 3 entry)))
           (should (equal (get-text-property 0 'ac-php-from candidate) "\\Demo\\Widget"))
           (should (equal (get-text-property 0 'summary candidate) "string"))))))))

(ert-deftest ac-php-documentation-frontends/imported-class-docs ()
  (ac-php-test--with-documentation-frontends
   (lambda (tags)
     (dolist (frontend '(auto-complete company))
       (let* ((candidate
               (ac-php-test--documentation-frontend-candidate
                tags
                "<?php\nnamespace Client;\nuse Demo\\Widget as Gizmo;\nGi|CURSOR|"
                frontend "Gizmo"))
              (doc (ac-php-test--documentation-frontend-text candidate frontend)))
         (should (string-match-p "Widget services\\." doc))
         (should (equal (get-text-property 0 'ac-php-help candidate) "Gizmo")))))))

(ert-deftest ac-php-documentation-frontends/fallback-without-source-metadata ()
  (let ((candidate (propertize "unknown(" 'ac-php-help "$id"
                               'ac-php-tag-type "f" 'ac-php-return-type "string")))
    (should (equal (ac-php-document candidate) "unknown($id) → string"))
    (should (equal (company-ac-php-document candidate) "unknown($id) → string"))))

(ert-deftest ac-php-documentation-frontends/header-keeps-colors-without-completion-metadata ()
  (ac-php-test--with-documentation-frontends
   (lambda (tags)
     (dolist (frontend '(auto-complete company))
       (let* ((candidate
               (ac-php-test--documentation-frontend-candidate
                tags "<?php\nfunction run(\\Demo\\Widget $widget) {\n$widget->fe|CURSOR|;\n}"
                frontend "fetch("))
              (doc (ac-php-test--documentation-frontend-text candidate frontend)))
         (dolist (element '(("fetch" . font-lock-function-name-face)
                            ("string" . font-lock-type-face)
                            ("public" . font-lock-keyword-face)
                            ("\\Demo\\Widget" . font-lock-constant-face)
                            ("→" . shadow)))
           (let ((position (string-match (regexp-quote (car element)) doc)))
             (should position)
             (should (eq (get-text-property position 'face doc) (cdr element)))))
         (should-not (string-match-p "\t\\|\\[access\\]\\|\\[ *from\\]" doc))
         (should-not (text-property-not-all 0 (length doc) 'ac-php-tags-data nil doc))
         (should-not (text-property-not-all 0 (length doc) 'ac-php-source-tag nil doc)))))))

(ert-deftest ac-php-documentation-frontends/phpdoc-does-not-change-insertion ()
  (ac-php-test--with-documentation-frontends
   (lambda (tags)
     (dolist (frontend '(auto-complete company))
       (let ((candidate
              (ac-php-test--documentation-frontend-candidate
               tags "<?php\nnamespace Demo;\nlook|CURSOR|" frontend "lookup(")))
         (ac-php-test--documentation-frontend-text candidate frontend)
         (with-ac-php-buffer-test "<?php\nlookup("
           (goto-char (point-max))
           (if (eq frontend 'company)
               (cl-letf (((symbol-function 'company-template-c-like-templatify)
                          (lambda (template)
                            (should (equal template "lookup($id)")))))
                 (company-ac-php-backend-post-completion candidate)
                 (should (equal (buffer-string) "<?php\nlookup($id)"))
                 (should (= (point) (point-max))))
             (let ((ac-last-completion (cons (copy-marker (point)) candidate))
                   (ac-php-template-candidates nil)
                   (ac-php-template-start-point nil))
               (cl-letf (((symbol-function 'ac-complete-php-template) #'ignore))
                 (ac-php-action))
               (should (equal (mapcar #'substring-no-properties ac-php-template-candidates)
                              '("$id)")))
               (should (= ac-php-template-start-point (point)))
               (should (equal (buffer-string) "<?php\nlookup("))))))))))

(provide 'ac-php-documentation-frontends-test)
;;; ac-php-documentation-frontends-test.el ends here
