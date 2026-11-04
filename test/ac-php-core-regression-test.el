;;; ac-php-core-regression-test.el --- Core review regressions -*- lexical-binding: t; -*-

;;; Commentary:
;; Exercise observable bugs and bound work in completion and indexing paths.

;;; Code:

(ert-deftest ac-php-regression/assignment-scan-advances-past-inner-semicolons ()
  (dolist (expression '("fetch('a;b')" "fetch(/* ; */ 'value')"
                        "fetch(function () { return 'x'; })"))
    (with-ac-php-buffer-test
        (concat "<?php\nfunction run() {\n$x = " expression ";\n$x[''];\n}")
      (search-forward "$x['")
      (let ((pos (point)) (calls 0)
            (search (symbol-function 'search-forward)))
        (cl-letf (((symbol-function 'search-forward)
                   (lambda (text &rest args)
                     (when (string= text ";")
                       (setq calls (1+ calls))
                       (when (> calls 12) (error "Non-advancing assignment scan")))
                     (apply search text args))))
          (should (equal (plist-get (ac-php--variable-assignment "x" pos) :text)
                         (if (string-match-p "/\\*" expression)
                             "fetch( 'value')" expression)))
          (should (= pos (point))))))))

(ert-deftest ac-php-regression/project-cache-directories-do-not-collide ()
  (let* ((directory (make-temp-file "ac-php-roots-" t))
         (ac-php-tags-path (expand-file-name "cache" directory))
         (roots (mapcar (lambda (name) (expand-file-name name directory))
                        '("a-b/c/" "a/b-c/"))))
    (unwind-protect
        (progn
          (dolist (root roots)
            (make-directory root t)
            (with-temp-file (expand-file-name ".ac-php-conf.json" root)
              (insert "{}")))
          (let ((first (ac-php--get-tags-save-dir (car roots)))
                (second (ac-php--get-tags-save-dir (cadr roots))))
            (should-not (equal first second))
            (should (equal first (ac-php--get-tags-save-dir
                                  (directory-file-name (car roots)))))))
      (delete-directory directory t))))

(ert-deftest ac-php-regression/config-cache-reuses-and-invalidates ()
  (let* ((directory (make-temp-file "ac-php-config-" t))
         (file (expand-file-name ".ac-php-conf.json" directory))
         (ac-php--config-cache (make-hash-table :test #'equal))
         (read-json (symbol-function 'json-read-file))
         (reads 0))
    (unwind-protect
        (progn
          (with-temp-file file (insert "{\"tag-dir\":\"first\"}"))
          (cl-letf (((symbol-function 'json-read-file)
                     (lambda (&rest args)
                       (setq reads (1+ reads))
                       (apply read-json args))))
            (dotimes (_ 5) (ac-php--get-config directory))
            (should (= reads 1))
            (with-temp-file file (insert "{\"tag-dir\":\"second-directory\"}"))
            (should (equal (cdr (assoc-string "tag-dir"
                                             (ac-php--get-config directory)))
                           "second-directory"))
            (should (= reads 2))
            (delete-file file)
            (should (ac-php--get-config directory))
            (should (= reads 3))))
      (delete-directory directory t))))

(ert-deftest ac-php-regression/custom-tag-directory-preserves-default-directory ()
  (let ((original default-directory))
    (cl-letf (((symbol-function 'ac-php--get-config)
               (lambda (_) '(("tag-dir" . "tags"))))
              ((symbol-function 'file-truename)
               (lambda (_) (error "Cannot resolve tag directory"))))
      (should-error (ac-php--get-tags-save-dir "/project/")))
    (should (equal original default-directory))))

(ert-deftest ac-php-regression/phpctags-uses-the-resolved-output-directory ()
  (cl-letf (((symbol-function 'ac-php--get-tags-save-dir)
             (lambda (_) "/cache/unique-project/")))
    (should (member "--output-dir=/cache/unique-project/"
                    (ac-php--ctags-opts "/project/" nil)))))

(ert-deftest ac-php-regression/shape-merge-retains-order-and-types ()
  (should (equal (ac-php--array-shapes-fields
                  '("array{first:int, shared:string, last:bool}"
                    "array{shared:int|string, added:float}"))
                 '(("first" . "int") ("shared" . "string|int")
                   ("last" . "bool") ("added" . "float")))))

(ert-deftest ac-php-regression/index-start-error-does-not-lock-retries ()
  (let ((ac-php--index-processes (make-hash-table :test #'equal))
        (ac-php-gen-tags-flag nil)
        (ac-php-tags-backend 'invalid)
        started)
    (should-error (ac-php--remake-tags "/project/" nil) :type 'user-error)
    (should-not ac-php-gen-tags-flag)
    (cl-letf (((symbol-function 'ac-php--remake-tags-ex)
               (lambda (&rest _) (setq started t))))
      (ac-php--remake-tags "/project/" nil))
    (should started)))

(defun ac-php-test--with-index-directories (function)
  "Call FUNCTION with isolated non-project and PHP project directories."
  (let* ((directory (file-name-as-directory
                     (file-truename (make-temp-file "ac-php-index-roots-" t))))
         (non-project (expand-file-name "outside/" directory))
         (project (expand-file-name "project/" directory))
         (file-exists (symbol-function 'file-exists-p)))
    (unwind-protect
        (progn
          (make-directory non-project t)
          (make-directory (expand-file-name "src/" project) t)
          (with-temp-file (expand-file-name ac-php-config-file project)
            (insert "{}"))
          ;; Keep real discovery inside this fixture, ignoring any project
          ;; markers in the machine's temporary directory or its parents.
          (cl-letf (((symbol-function 'file-exists-p)
                     (lambda (file)
                       (and (string-prefix-p directory (expand-file-name file))
                            (funcall file-exists file)))))
            (funcall function non-project project)))
      (delete-directory directory t))))

(ert-deftest ac-php-regression/index-commands-recover-after-missing-project ()
  (ac-php-test--with-index-directories
   (lambda (non-project project)
     (dolist (command '(ac-php-remake-tags ac-php-remake-tags-all))
       (dolist (initial-flag '(nil t))
         (let ((ac-php--index-processes (make-hash-table :test #'equal))
               (ac-php-gen-tags-flag initial-flag)
               (ac-php-tags-backend 'mago)
               (ac-php-phptags-index-progress 37)
               process invocation)
           (unwind-protect
               (with-temp-buffer
                 (setq default-directory non-project
                       buffer-file-name (expand-file-name "notes.txt" non-project))
                 (cl-letf (((symbol-function 'ac-php--mago-tags-executable)
                            (lambda () "test-generator"))
                           ((symbol-function 'ac-php--get-tags-save-dir)
                            (lambda (_) (expand-file-name "tags/" project)))
                           ((symbol-function 'ac-php--tags-process-command)
                            (lambda (root force backend)
                              (setq invocation (list root force backend))
                              '("test-generator")))
                           ((symbol-function 'start-process)
                            (lambda (&rest _)
                              (setq process
                                    (make-pipe-process :name "ac-php-retry"
                                                       :noquery t)))))
                   (should-error (call-interactively command) :type 'user-error)
                   (should-not invocation)
                   (should-not process)
                   (should-not ac-php--index-process)
                   (should-not ac-php-mode)
                   (should (= ac-php-phptags-index-progress 37))
                   (should (eq ac-php-gen-tags-flag initial-flag))
                   (should (= (hash-table-count ac-php--index-processes) 0))
                   ;; Retry from a nested PHP source directory.  In particular,
                   ;; a legacy global busy flag must not prevent this startup.
                   (setq default-directory (expand-file-name "src/" project)
                         buffer-file-name (expand-file-name "example.php"
                                                            default-directory))
                   (should (eq (call-interactively command) process))
                   (should (equal invocation
                                  (list project
                                        (eq command 'ac-php-remake-tags-all)
                                        'mago)))
                   (should (process-live-p process))
                   (should (eq (gethash project ac-php--index-processes) process))
                   (should (eq ac-php--index-process process))
                   (should ac-php-mode)
                   (should ac-php-gen-tags-flag)))
             (when process (delete-process process)))))))))

(ert-deftest ac-php-regression/index-missing-project-keeps-other-project-running ()
  (ac-php-test--with-index-directories
   (lambda (non-project project)
     (let ((ac-php--index-processes (make-hash-table :test #'equal))
           (ac-php-gen-tags-flag t)
           (process (make-pipe-process :name "ac-php-other-project" :noquery t))
           (origin (generate-new-buffer " *ac-php-other-project*")))
       (unwind-protect
           (progn
             (process-put process 'ac-php-root project)
             (process-put process 'ac-php-progress 61)
             (puthash project process ac-php--index-processes)
             (with-current-buffer origin (ac-php--index-attach-buffer process))
             (with-temp-buffer
               (setq default-directory non-project)
               (dolist (command '(ac-php-remake-tags ac-php-remake-tags-all))
                 (should-error (call-interactively command) :type 'user-error)
                 (should-not ac-php--index-process)
                 (should-not ac-php-mode)
                 (should (process-live-p process))
                 (should (eq (gethash project ac-php--index-processes) process))
                 (should (= (hash-table-count ac-php--index-processes) 1))
                 (should ac-php-gen-tags-flag)
                 (should (equal (process-get process 'ac-php-buffers)
                                (list origin)))
                 (with-current-buffer origin
                   (should ac-php-mode)
                   (should (eq ac-php--index-process process))
                   (should (= (process-get process 'ac-php-progress) 61))))))
         (delete-process process)
         (kill-buffer origin))))))

(ert-deftest ac-php-regression/index-output-retains-arbitrary-chunks ()
  (let ((process (make-pipe-process :name "ac-php-chunks" :noquery t))
        (text "75% parsed\r\nPHPParser: invalid source\nfinal"))
    (unwind-protect
        (progn
          (dotimes (index (length text))
            (ac-php-phptags-index-process-filter
             process (substring text index (1+ index))))
          (should (= (process-get process 'ac-php-progress) 75))
          (should (equal (process-get process 'ac-php-errors)
                         "\nPHPParser: invalid source"))
          (should (equal (process-get process 'ac-php-pending) "final")))
      (delete-process process))))

(ert-deftest ac-php-regression/index-completion-clears-origin-and-keeps-other-project ()
  (let ((first (make-pipe-process :name "ac-php-first" :noquery t))
        (second (make-pipe-process :name "ac-php-second" :noquery t))
        (origin (generate-new-buffer " *ac-php-origin*"))
        (other (generate-new-buffer " *ac-php-other*"))
        (ac-php--index-processes (make-hash-table :test #'equal))
        (ac-php-gen-tags-flag t))
    (unwind-protect
        (progn
          (process-put first 'ac-php-root "/first/")
          (process-put second 'ac-php-root "/second/")
          (puthash "/first/" first ac-php--index-processes)
          (puthash "/second/" second ac-php--index-processes)
          (with-current-buffer origin (ac-php--index-attach-buffer first))
          (with-current-buffer other (ac-php--index-attach-buffer second))
          (delete-process first)
          (with-current-buffer other (ac-php--index-finished first "closed\n"))
          (should-not (buffer-local-value 'ac-php-mode origin))
          (should (buffer-local-value 'ac-php-mode other))
          (should (eq second (gethash "/second/" ac-php--index-processes)))
          (should ac-php-gen-tags-flag)
          (should-not (gethash "/first/" ac-php--index-processes)))
      (delete-process first)
      (delete-process second)
      (kill-buffer origin)
      (kill-buffer other))))

(ert-deftest ac-php-regression/nested-call-uses-result-return-type ()
  (dolist (expression '("outer(inner())" "outer(/* comment */ inner())"
                        "(outer(inner()))"))
    (dolist (frontend '(core company auto-complete))
      (should
       (equal
        (ac-php-test--array-shape-candidates
         (concat "<?php\n/** @return array{outer_key:int} */\n"
                 "function outer($value) {}\n"
                 "/** @return array{inner_key:int} */\nfunction inner() {}\n"
                 "function run() {\n$x = " expression ";\n$x['|CURSOR|'];\n}")
         frontend)
        '("outer_key"))))))

(ert-deftest ac-php-regression/local-method-type-respects-receiver ()
  (dolist (frontend '(core company auto-complete))
    (should
     (equal
      (ac-php-test--array-shape-candidates
       (concat "<?php\nclass A {\n/** @param array{key_a:int} $config */\n"
               "public function configure($config) {}\n}\n"
               "class B {\n/** @param array{key_b:int} $config */\n"
               "public function configure($config) {}\n}\n"
               "function run(\\A $a) {\n$a->configure(['|CURSOR|']);\n}")
       frontend)
      '("key_a")))))

(ert-deftest ac-php-regression/grouped-imports-share-namespace-rules ()
  (with-ac-php-buffer-test
      (concat "<?php\nnamespace Client;\n"
              "use Vendor\\{Foo, Bar as Alias, function helper, const VALUE};\n"
              "function run(Foo $foo) {\n$foo->member;\n}\n"
              "namespace Other;\nuse Wrong\\Foo;\n")
    (search-forward "$foo->")
    (let ((functions (make-hash-table :test #'equal)))
      (puthash "\\Vendor\\Foo" ["c" "\\Vendor\\Foo" "" "0:1" "\\Vendor\\Foo"]
               functions)
      (should (equal (ac-php--get-class-full-name-in-cur-buffer
                      "Foo" functions nil) "\\Vendor\\Foo"))
      (should (equal (ac-php--phpstan-import-class-name "Alias") "\\Vendor\\Bar"))
      (should-not (ac-php-get-use-as-name "helper"))
      (should-not (ac-php-get-use-as-name "VALUE"))
      (goto-char (point-max))
      (should (equal (ac-php-get-use-as-name "Foo") "\\Wrong\\Foo")))))

(ert-deftest ac-php-regression/source-cache-invalidates-and-suppresses-mode-hooks ()
  (let* ((file (make-temp-file "ac-php-source-" nil ".php" "<?php\nclass First {}"))
         (ac-php--source-buffers (make-hash-table :test #'equal))
         (read-source (symbol-function 'insert-file-contents))
         (reads 0) (hooks 0) user-buffer)
    (unwind-protect
        (let ((php-mode-hook (list (lambda () (setq hooks (1+ hooks))))))
          (cl-letf (((symbol-function 'insert-file-contents)
                     (lambda (name &rest args)
                       (when (equal name file) (setq reads (1+ reads)))
                       (apply read-source name args))))
            (dotimes (_ 5)
              (should (equal (ac-php--call-with-source file #'buffer-string)
                             "<?php\nclass First {}")))
            (should (= reads 1))
            (should (= hooks 0))
            (with-temp-file file (insert "<?php\nclass SecondVersion {}"))
            (should (string-match-p "SecondVersion"
                                    (ac-php--call-with-source file #'buffer-string)))
            (should (= reads 2))
            (setq user-buffer (generate-new-buffer " *ac-php-user-source*"))
            (with-current-buffer user-buffer
              (setq buffer-file-name file)
              (insert "unsaved source"))
            (should (equal (ac-php--call-with-source file #'buffer-string)
                           "unsaved source"))
            (should (= reads 2))))
      (when user-buffer
        (with-current-buffer user-buffer (set-buffer-modified-p nil))
        (kill-buffer user-buffer))
      (maphash (lambda (_ entry) (when (buffer-live-p (cdr entry))
                                  (kill-buffer (cdr entry))))
               ac-php--source-buffers)
      (delete-file file))))

(ert-deftest ac-php-regression/prefix-index-preserves-order-case-and-generation ()
  (let* ((functions (make-hash-table :test #'equal))
         (tags (list nil functions nil [] "/project/"))
         (first ["f" "\\App\\Fetch(" "$id" "0:1" "bool"])
         (second ["f" "\\App\\fetch_other(" "" "0:2" "int"])
         (third ["c" "\\Other\\Fetch" "" "0:3" "\\Other\\Fetch"]))
    (dolist (tag (list first second third)) (puthash (aref tag 1) tag functions))
    (should (equal (ac-php--function-prefix-matches tags "\\App\\fet" t)
                   (list first second)))
    (should (equal (ac-php--function-prefix-matches tags "\\App\\fet")
                   (list second)))
    (let ((map (symbol-function 'maphash)) (scans 0))
      (cl-letf (((symbol-function 'maphash)
                 (lambda (function table)
                   (when (eq table functions) (setq scans (1+ scans)))
                   (funcall map function table))))
        (dotimes (_ 5)
          (should-not (ac-php--function-prefix-matches tags "\\Missing")))
        (should (= scans 0))
        (puthash "\\Missing" ["c" "\\Missing" "" "0:4" "\\Missing"] functions)
        (should (ac-php--function-prefix-matches tags "\\Missing"))
        (should (= scans 1))))))

(ert-deftest ac-php-regression/index-deduplicates-per-project-even-in-debug-mode ()
  (let ((ac-php--index-processes (make-hash-table :test #'equal))
        (ac-php-debug-flag t)
        (ac-php-gen-tags-flag nil)
        (buffer (generate-new-buffer " *ac-php-index-worker*")) first second)
    (unwind-protect
        (with-current-buffer buffer
          (cl-letf (((symbol-function 'ac-php--remake-tags-ex)
                     (lambda (root rebuild)
                       (ac-php--rebuild-file-list root rebuild)))
                    ((symbol-function 'ac-php--effective-tags-backend)
                     (lambda () 'mago))
                    ((symbol-function 'ac-php--tags-process-command)
                     (lambda (&rest _) '("cat"))))
            (setq first (ac-php--remake-tags "/first/" nil))
            (should (eq first (ac-php--remake-tags "/first/" t)))
            (setq second (ac-php--remake-tags "/second/" nil))
            (should-not (eq first second))
            (should (= (hash-table-count ac-php--index-processes) 2))
            (should ac-php-gen-tags-flag)))
      (when first (delete-process first))
      (when second (delete-process second))
      (kill-buffer buffer))))

(ert-deftest ac-php-regression/transitive-import-cache-rechecks-leaf-source ()
  (ac-php-test--with-import-project
   '(("Leaf.php" ("\\Acme\\Leaf")
      "<?php\nnamespace Acme;\n/** @phpstan-type Config array{first:int} */\nclass Leaf {}")
     ("Types.php" ("\\Acme\\Types")
      "<?php\nnamespace Acme;\n/** @phpstan-import-type Config from Leaf */\nclass Types {}"))
   (lambda (tags directory)
     (let ((content (ac-php-test--import-content
                     " * @phpstan-import-type Config from Types" "Config")))
       (should (equal (ac-php-test--import-candidates content tags directory)
                      '("first")))
       (with-temp-file (expand-file-name "Leaf.php" directory)
         (insert "<?php\nnamespace Acme;\n/** @phpstan-type Config array{second_key:bool} */\nclass Leaf {}"))
       (should (equal (ac-php-test--import-candidates content tags directory)
                      '("second_key")))))))

(ert-deftest ac-php-regression/source-cache-has-a-bounded-number-of-buffers ()
  (let ((directory (make-temp-file "ac-php-source-limit-" t))
        (ac-php--source-buffers (make-hash-table :test #'equal)))
    (unwind-protect
        (progn
          (dotimes (index 35)
            (let ((file (expand-file-name (format "%d.php" index) directory)))
              (with-temp-file file (insert "<?php\nclass Example {}"))
              (should (ac-php--call-with-source file #'buffer-string))))
          (should (<= (hash-table-count ac-php--source-buffers) 32)))
      (maphash (lambda (_ entry) (when (buffer-live-p (cdr entry))
                                  (kill-buffer (cdr entry))))
               ac-php--source-buffers)
      (delete-directory directory t))))

(ert-deftest ac-php-regression/pending-index-is-not-returned-as-tags-data ()
  (let (started)
    (cl-letf (((symbol-function 'ac-php-get-tags-file)
               (lambda () '("/project/" "/missing/tags.el" "/missing/vendor.el")))
              ((symbol-function 'file-exists-p) (lambda (_) nil))
              ((symbol-function 'ac-php-remake-tags)
               (lambda () (setq started t) 'pending-process)))
      (should-not (ac-php-get-tags-data))
      (should started))))

(ert-deftest ac-php-regression/completion-is-empty-while-first-index-is-pending ()
  (with-ac-php-buffer-test "<?php\nfunction run() {\n$object->mem"
    (goto-char (point-max))
    (cl-letf (((symbol-function 'ac-php-get-tags-data) (lambda () nil)))
      (should-not (ac-php-candidate)))))

(provide 'ac-php-core-regression-test)
;;; ac-php-core-regression-test.el ends here
