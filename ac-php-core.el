;;; ac-php-core.el --- The core library of the ac-php  -*- lexical-binding: t; -*-

;; Copyright (C) 2019 Serghei Iakovlev <sadhooklay@gmail.com>
;; Copyright (C) 2014-2019 jim <xcwenn@qq.com>
;; Copyright (C) 2011-2016 Jan Erik Hanssen and Anders Bakken
;; Copyright (C) 2011 Joseph <jixiuf@gmail.com>
;; Copyright (C) 2010 Brian Jiang

;; Author: jim <xcwenn@qq.com>
;;      Serghei Iakovlev <sadhooklay@gmail.com>
;; Maintainer: jim
;; URL: https://github.com/xcwen/ac-php
;; Version: 2.8.2
;; Keywords: completion, convenience, intellisense
;; Package-Requires: ( (emacs "24.4") (dash "1") (php-mode "1") (s "1") (f "0.17.0") (popup "0.5.0") (xcscope "1.0"))
;; Compatibility: GNU Emacs: 24.4, 25.x, 26.x, 27.x

;; This file is NOT part of GNU Emacs.

;;; License

;; This program is free software; you can redistribute it and/or modify
;; it under the terms of the GNU General Public License as published by
;; the Free Software Foundation, either version 3 of the License, or
;; (at your option) any later version.

;; This program is distributed in the hope that it will be useful,
;; but WITHOUT ANY WARRANTY; without even the implied warranty of
;; MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
;; GNU General Public License for more details.

;; You should have received a copy of the GNU General Public License
;; along with this program.  If not, see <http://www.gnu.org/licenses/>.

;;; Commentary:

;; The core library of the `ac-php' package.  Acts like a backend for the
;; following components:
;;
;; - `ac-php'
;; - `company-php'
;; - `helm-ac-php-apropros'
;;
;; Can be used as an API to build your own components.  This engine currently
;; provides:
;;
;; - Support of PHP code completion
;; - Support of jumping to definition/declaration/inclusion-file
;;
;; When creating this package, the ideas of the following packages were used:
;;
;; - auto-java-complete
;;
;;   - `ac-php-remove-unnecessary-items-4-complete-method'
;;   - `ac-php-split-string-with-separator'
;;
;; - auto-complete-clang
;;
;; - rtags
;;
;;   - `ac-php-location-stack-index'
;;
;; Many options available under Help:Customize
;; Options specific to ac-php-core are in
;;   Convenience/Completion/Auto Complete
;;
;; Known to work with Linux and macOS.  Windows support is in beta stage.
;; For more info and examples see URL `https://github.com/xcwen/ac-php' .
;;
;; Bugs: Bug tracking is currently handled using the GitHub issue tracker
;; (see URL `https://github.com/xcwen/ac-php/issues')


;;; Code:

(require 'json)    ; `json-encode', `json-read-file'
(require 's)       ; `s-equals', `s-upcase', `s-matches-p', `s-replace', ...
(require 'f)       ; `f-write-text', `f-full', `f-join', `f-exists?', ...

(require 'xcscope) ; `cscope-find-egrep-pattern', `cscope-prompt-for-symbol'
(require 'popup)   ; `popup-tip'
(require 'dash)
(require 'eldoc)

(require 'cl-lib) ; `cl-reduce', `cl-decf'

(defvar cscope-no-mouse-prompts nil
  "Suppress mouse prompts while reading a Cscope search pattern.")

;;; Customization

;;;###autoload
(defgroup ac-php nil
  "Auto Completion source for PHP."
  :prefix "ac-php-"
  :group 'auto-complete
  :group 'completion
  :group 'convenience
  :link '(url-link :tag "Bug Tracker" "https://github.com/xcwen/ac-php/issues")
  :link '(url-link :tag "GitHub Page" "https://github.com/xcwen/ac-php")
  :link '(emacs-commentary-link :tag "Commentary" "ac-php"))

(defcustom ac-php-php-executable (executable-find "php")
  "Set PHP command line interpreter executable path.
For more see URL `http://php.net/manual/en/features.commandline.php'."
  :group 'ac-php
  :type 'string)

(defcustom ac-php-cscope (executable-find "cscope")
  "Set the Csope executable path.
For more see URL `http://cscope.sourceforge.net/'."
  :group 'ac-php
  :type 'string)

(defcustom ac-php-use-cscope-flag nil
  "Non-nil means use Cscope if it is possible.
To use this feature you'll need to set cscope executable path in
`ac-php-cscope'.  For more see URL `http://cscope.sourceforge.net'."
  :group 'ac-php
  :type 'boolean)

(defcustom ac-php-auto-update-intval 3600
  "The interval between automatic re-indexing project's files (in seconds)."
  :group 'ac-php
  :type 'integer)

(defcustom ac-php-project-root-dir-use-truename t
  "Non-nil means always expand filenames using function `file-truename'."
  :group 'ac-php
  :type 'boolean)

(defcustom ac-php-mode-line
  '(:eval (format "AP%s" (ac-php-mode-line-project-status)))
  "Mode line lighter for ac-php.
Set this variable to nil to disable the lighter."
  :group 'ac-php
  :type 'sexp
  :risky t)

(defcustom ac-php-tags-path (concat (getenv "HOME") "/.cache/ac-php")
  "Use this directory as a base path for the per-projects tags directories..

The idea is to have a common local directory for the all projects.  This path
get extended with the directory tree of the project that you are indexing the
tags for."
  :group 'ac-php
  :type 'string)

(defcustom ac-php-tags-backend 'auto
  "Tag generator backend.
When set to `auto', prefer `mago' when
`ac-php-mago-tags-executable' can be found, otherwise use `phpctags'."
  :group 'ac-php
  :type '(choice
          (const auto)
          (const mago)
          (const phpctags)))

(defcustom ac-php-mago-tags-executable "ac-php-mago-tags"
  "Path to the Mago-based tag generator."
  :group 'ac-php
  :type 'file)

;;; Internal configuration

(defconst ac-php-config-file ".ac-php-conf.json"
  "Per-project configuration file.")

(defvar ac-php-root-directory (file-name-directory (or load-file-name buffer-file-name))
  "The ac-php package location.")

(defvar ac-php-ctags-executable (concat ac-php-root-directory "phpctags")
  "Set the Phpctags executable path.  Don't change the value of this variable.")


(defvar ac-php-debug-flag nil
  "Non-nil means enable verbose mode when processing autocomplete.
Please notice, enabling this option entails detailed output of debugging
information to the ‘*Messages*’ buffer.  This feature is designed for
ac-php developer only.")

(defvar ac-php-gen-tags-flag nil
  "Non-nil means that remaking tags currently is under process.")

(defvar ac-php-phptags-index-progress 0
  "The re-index progress indicator.
Meant for `ac-php-mode-line-project-status'")

;; The key is an absolute tags filename.  Each value is a plist containing the
;; file signatures and the merged tags data.  The vendor signature is stored in
;; the project entry so that changing only tags-vendor.el also invalidates the
;; merged data.
(defvar ac-php-tag-last-data-list (make-hash-table :test #'equal)
  "Hash table holding in-memory tags data, keyed by tags filename.")

(defvar g-ac-php-tmp-tags nil
  "Temporary container populated while loading a generated tags file.")

(defconst ac-php-re-classlike-pattern
  (concat
   ;; Class declaration may begin at the 1st line.
   ;; The file may start with <?php, <? or <%.
   ;; Example:
   ;;   <?php class Foo {}
   "^\\(?:<\\(?:\\?\\(?:php\\)?\\|%\\)\\)?"
   ;; Then see if 'abstract' or 'final' appear
   "\\s-*\\(?:\\(?:abstract\\|final\\)\\s-+\\)?"
   ;; The classlike type
   "\\(?:class\\|trait\\|enum\\)"
   ;; Its name, which is the first captured group in the regexp.
   ;; See URL `https://www.php.net/manual/en/language.oop5.basic.php'
   "\\s-+\\([a-zA-Z_-ÿ][a-zA-Z0-9_-ÿ]*\\)")
  "The regular expression for classlike.")

(defconst ac-php-re-namespace-unit-pattern
  (concat
   ;; First see if '\' appear, although really it is not valid for all use cases
   "\\(?:\\\\\\)?"
   ;; We allow backslashes in the name to handle namespaces, parts of namespaces
   ;; and fully qualified class names, but again this is not necessarily correct
   ;; for all use cases.
   ;; See URL `https://www.php.net/manual/en/language.oop5.basic.php'
   "\\(?:[a-zA-Z_-ÿ][a-zA-Z0-9_-ÿ\\]*\\)")
  "The regular expression for a part of a namespace.")

(defconst ac-php-re-namespace-pattern
  (concat
   ;; Namespace declaration may begin at the 1st line.
   ;; The file may start with <?php, <? or <%.
   ;; Example:
   ;;   <?php namespace Acme;
   "^\\(?:<\\(?:\\?\\(?:php\\)?\\|%\\)\\)?"
   ;; Namespace keyword
   "\\s-*namespace"
   ;; Namespace value, which is the first captured group in the regexp
   "\\s-+\\(" ac-php-re-namespace-unit-pattern "\\)\\s-*;")
  "The regular expression for a namespace.")

(defconst ac-php-re-beginning-of-defun-pattern
  (concat
   "^\\s-*"
   "\\(?:\\(?:abstract\\|final\\|private\\|protected"
   "\\|public\\|static\\)\\s-+\\)"
   "*function\\s-+&?\\(\\(?:\\sw\\|\\s_\\)+\\)\\s-*(")
  "Regular expression for a PHP function.")

(defconst ac-php-re-annotated-var-pattern
  (concat
   "@var"
   "\\s-+\\(" ac-php-re-namespace-unit-pattern "\\)\\>\\s-+")
  "The regular expression for a class inside an annotated variable.")

(defvar ac-php-prefix-str "")

(defvar ac-php-extra-completion-functions nil
  "Functions providing project-specific completion at point.

Each function is called with TAGS-DATA, which is nil while a frontend asks
only for a prefix.  It should return nil when inactive, or a plist containing
`:prefix' and, when TAGS-DATA is non-nil, `:candidates'.  Candidate strings
may carry the same text properties as regular ac-php candidates.")

(defun ac-php-extra-completion-at-point (&optional tags-data)
  "Return the first extra completion result at point using TAGS-DATA."
  (save-excursion
    (run-hook-with-args-until-success
     'ac-php-extra-completion-functions tags-data)))

(defvar ac-php-location-stack-index 0)

(defvar ac-php-location-stack nil)

(defvar ac-php--php-key-list '("public"
                               "class" "namespace" "protected"
                               "private" "function" "while"
                               "extends" "return" "static" "global" "continue" "abstract" "finally" "instanceof"))

(defvar ac-php-rebuild-tmp-error-msg nil)

(defvar ac-php-max-bookmark-count 500)

;;; Utils

(defmacro ac-php--debug (format-string &rest args)
  "Display a debug message at the bottom of the screen.
The message also goes into the ‘*Messages*’ buffer, if ‘message-log-max’
is non-nil.  Return the debug message.  For FORMAT-STRING and ARGS explanation
refer to `message' function."
  `(when ac-php-debug-flag
     (message (concat "[DEBUG]: " ,format-string) ,@args)))

(defun ac-php--get-timestamp (time-spec)
  "Get UNIX timestamp from the TIME-SPEC."
  (+ (* (nth 0 time-spec) 65536)
     (nth 1 time-spec)))

(defun ac-php--reduce-path (path max-len)
  "Return a modified version of PATH no longer than MAX-LEN.

This function replaces some components with single characters starting from the
left to try and get the path down to MAX-LEN"
  (let* ((components (split-string (abbreviate-file-name path) "/"))
         (len (+ (1- (length components))
                 (cl-reduce '+ components :key 'length)))
         shortened-components)
    (while (and (> len max-len)
                (cdr components))
      (push (if (= 0 (length (car components)))
                "/"
              (string (elt (car components) 0) ?/))
            shortened-components)
      (setq len (- len (1- (length (car components))))
            components (cdr components)))
    (concat (apply #'concat (nreverse shortened-components))
            (mapconcat #'identity components "/"))))

(defun ac-php-g--project-root-dir (tags-data)
  "Return a project path using the TAGS-DATA list."
  (nth 4 tags-data))

(defsubst ac-php--in-comment-p (&optional pos)
  "Determine whether POS is inside a comment."
  (let ((state (save-excursion (syntax-ppss pos))))
    (nth 4 state)))

(defsubst ac-php--in-string-or-comment-p (&optional pos)
  "Determine whether POS is inside a string or comment."
  (let ((state (save-excursion (syntax-ppss pos))))
    (nth 8 state)))

;; See: https://github.com/emacs-php/php-mode/issues/503
(defun ac-php--beginning-of-defun (&optional arg)
  "Move to the beginning of the ARGth PHP function from point.
A replacemant for PHP's version `php-beginning-of-defun'."
  (let (found-p (arg (or arg 1)))
    (while (> arg 0)
      (setq found-p (re-search-backward
                     ac-php-re-beginning-of-defun-pattern
                     nil 'noerror))
      (setq arg (1- arg)))
    (while (< arg 0)
      (end-of-line 1)
      (let ((opoint (point)))
        (ac-php--beginning-of-defun 1)
        (forward-list 2)
        (forward-line 1)
        (if (eq opoint (point))
            (setq found-p (re-search-forward
                           ac-php-re-beginning-of-defun-pattern
                           nil 'noerror)))
        (setq arg (1+ arg))))
    (not (null found-p))))

;; See: https://github.com/emacs-php/php-mode/issues/503
(defun ac-php--end-of-defun (&optional arg)
  "Move the end of the ARGth PHP function from point.
A replacemant for PHP's version `php-en-of-defun'.

See `ac-php--beginning-of-defun'."
  (ac-php--beginning-of-defun (- (or arg 1))))

(defsubst ac-php--in-function-p (&optional pos)
  "Determine whether POS is inside a function."
  (let (bof (pos (or pos (point))))
    (save-excursion
      (goto-char pos)
      (when (ac-php--beginning-of-defun)
        (setq bof (point))
        (condition-case nil
            (progn
              (ac-php--end-of-defun)
              (and (> pos bof)
                   (< pos (point))))
          ;; Completion commonly runs while the current function is still
          ;; unbalanced.  Its beginning is still a useful scope boundary.
          (scan-error (> pos bof)))))))

(defun ac-php-toggle-debug ()
  "Toggle debug mode.
Please notice, enabling debug mode entails detailed output of debugging
information to the ‘*Messages*’ buffer.  This feature is designed for
ac-php developer only."

  (interactive)
  (let ((debug-p (not ac-php-debug-flag)))
    (progn
      (setq ac-php-debug-flag debug-p
            debug-on-error debug-p)
      (message "Debug mode was %s in ac-php"
               (if debug-p "enabled" "disabled")))))

(defun ac-php-mode-line-project-status ()
  "Report status of current project index."
  (format ":%02d%%%%" ac-php-phptags-index-progress))

(defun ac-php-location-stack-push ()
  "Doc."
  (let ((bm (ac-php-current-location)))
    (if (functionp 'xref-push-marker-stack)
        (xref-push-marker-stack)
      (ring-insert (with-no-warnings find-tag-marker-ring) (point-marker)))
    (while (> ac-php-location-stack-index 0)
      (cl-decf ac-php-location-stack-index)
      (pop ac-php-location-stack))
    (unless (string= bm (nth 0 ac-php-location-stack))
      (push bm ac-php-location-stack)
      (when (> (length ac-php-location-stack) ac-php-max-bookmark-count)
        (nbutlast ac-php-location-stack
                  (- (length ac-php-location-stack)
                     ac-php-max-bookmark-count))))))

;; function
(defun ac-php-goto-line-col (line column)
  "Doc LINE COLUMN."
  (goto-char (point-min))
  (forward-line (1- line))
  (beginning-of-line)
  (forward-char (1- column)))


(defun  ac-php--get-common-json-file ()
  "Doc LINE COLUMN."
  (concat ac-php-tags-path "/common.el"  )
  )

(defun ac-php-current-location (&optional offset)
  "Doc OFFSET."
  (format "%s:%d:%d" (or (buffer-file-name) (buffer-name))
          (line-number-at-pos offset) (1+ (- (or offset (point)) (line-beginning-position)))))
(defun ac-php--string=-ignore-care(str1 str2)
  "Doc STR2 STR1."
  (s-equals?(s-upcase str1) (s-upcase str2))
  ;; (not (integer-or-marker-p (compare-strings str1 0 nil str2 0 nil t)))
  )

(defun ac-php-find-file-or-buffer (file-or-buffer &optional other-window)
  "Doc FILE-OR-BUFFER OTHER-WINDOW."
  (if (file-exists-p file-or-buffer)
      (if other-window
          (find-file-other-window file-or-buffer)
        (find-file file-or-buffer))
    (let ((buf (get-buffer file-or-buffer)))
      (cond ((not buf) (message "No buffer named %s; you can M-x: ac-php-remake-tags-all fix it" file-or-buffer))
            (other-window (switch-to-buffer-other-window file-or-buffer))
            (t (switch-to-buffer file-or-buffer))))))


(defun ac-php-goto-location (location &optional other-window)
  "Go to a location passed in.
It can be either: file,12 or file:13:14 or plain file LOCATION OTHER-WINDOW."
  ;; (message (format "ac-php-goto-location \"%s\"" location))
  (when (> (length location) 0)
    (cond ((string-match "\\(.*\\):\\([0-9]+\\):\\([0-9]+\\)" location)
           (let ((line (string-to-number (match-string-no-properties 2 location)))
                 (column (string-to-number (match-string-no-properties 3 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;; (run-hooks ac-php-after-find-file-hook)
             (ac-php-goto-line-col line column)
             t))
          ((string-match "\\(.*\\):\\([0-9]+\\)" location)
           (let ((line (string-to-number (match-string-no-properties 2 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;; (run-hooks ac-php-after-find-file-hook)
             (goto-char (point-min))
             (forward-line (1- line))
             t))
          ((string-match "\\(.*\\),\\([0-9]+\\)" location)
           (let ((offset (string-to-number (match-string-no-properties 2 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;; (run-hooks ac-php-after-find-file-hook)
             (goto-char (1+ offset))
             t))
          (t
           (if (string-match "^ +\\(.*\\)$" location)
               (setq location (match-string-no-properties 1 location)))
           (ac-php-find-file-or-buffer location other-window)))
    ;; (ac-php-location-stack-push)
    ))

(defsubst ac-php-clean-document (s)
  "Doc S."
  (when s
    (setq s (replace-regexp-in-string "<#\\|#>\\|\\[#" "" s))
    (setq s (replace-regexp-in-string "#\\]" " " s)))
  s)

(defun ac-php--tag-name-is-function (tag-name)
  "Doc TAG-NAME."
  (s-matches-p "(" tag-name))

;; "Split STR into substrings bounded by REGEXP.

;; This function is a tool like `split-string', but it treat separator as an
;; element of returned list for example:

;;   \(ac-php-split-string-with-separator 'abc.def.g' '\\.' '.')

;; will return:

;;   '('abc' '.' 'def' '.' 'g')

;; The REPLACEMENT may used to return instead of REGEXP.  For OMIT-NULLS
;; refer to original `split-string' function.

;; Note: To conveniently describe in the documentation, double quotes (\") have
;; been replaced by '."

(defun ac-php-split-string-with-separator (str regexp &optional replacement omit-nulls)
  "Split STR into substrings bounded by REGEXP.
The REPLACEMENT may used to return instead of REGEXP.  For OMIT-NULLS
refer to original `split-string' function.

Note: To conveniently describe in the documentation, double quotes (\") have
been replaced by '."
  (when str
    (let ((start 0)
          (str-length (length str))
          split-list)
      (while (and (< start str-length)
                  (string-match regexp str start))
        (let ((separator-start (match-beginning 0))
              (separator-end (match-end 0)))
          (when (= separator-start separator-end)
            (error "Separator regexp must not match an empty string: %s" regexp))
          (when (or (not omit-nulls) (> separator-start start))
            (push (substring-no-properties str start separator-start)
                  split-list))
          (push (or replacement regexp) split-list)
          (setq start separator-end)))
      (when (or (not omit-nulls) (< start str-length))
        (push (substring-no-properties str start) split-list))
      (nreverse split-list))))

;; "Clean PARSER-DATA from unnecessary elements.

;; This function is used to drop all elements before ';'.  For example:

;;   \(ac-php--get-clean-node '('A' ';' 'B'))

;; will return:

;;   \('B')

;; The CHECK-LEN may be passed to indicate the limit to analyze items:

;;   \(ac-php--get-clean-node '('A' 'B' 'C' 'D') 2)

;; will return:

;;   \('A' 'B')

;; Note: To conveniently describe in the documentation, double quotes (\") have
;; been replaced by '."

(defun ac-php--get-clean-node (parser-data &optional check-len)
  "Clean PARSER-DATA from unnecessary elements.
The CHECK-LEN may be passed to indicate the limit to analyze items."
  (ac-php--debug "Going to clean parser data: %S" parser-data)
  (let ((remaining (or check-len (length parser-data)))
        ret-data
        item)
    (while (and parser-data (> remaining 0))
      (setq item (pop parser-data))
      (if (and (stringp item)
               (string= item ";"))
          (setq ret-data nil)
        (push item ret-data))
      (setq remaining (1- remaining)))

    (setq ret-data (reverse ret-data))
    (ac-php--debug "Parser data after cleaning up is: %S" ret-data)
    ret-data))

(defun ac-php--get-node-parser-data (parser-data)
  "Get keywords node from a PARSER-DATA."
  (let* ((check-len (1- (length parser-data)))
         (last-item (nth check-len parser-data))
         ret-data)
    (if (and (stringp last-item)
             (string= last-item "__POINT__"))
        (setq ret-data (ac-php--get-clean-node parser-data check-len))
      ;; TODO: Until version 2.0.7 the code below worked incorrectly.
      ;; Previous implementation just did the following test:
      ;;
      ;; (when last-item
      ;;   (setq ret-data (ac-php--get-node-parser-data last-item)))
      ;;
      ;; So I fixed this.  However I'll need to verify that
      ;; all still works as expected.  Consider this as an experimental branch.
      (when (and last-item (listp last-item))
        (progn
          (setq ret-data (ac-php--get-node-parser-data last-item))
          (ac-php--debug "The node after deep scan is: %S" ret-data))))
    ret-data))

(defun ac-php--get-key-list-from-parser-data (parser-data)
  "Get keywords list from the PARSER-DATA list."
  (ac-php--debug "Building a key list from the parser data: %S" parser-data)
  (let ((first-key (car parser-data))
        (items (cdr parser-data))
        ret
        new-items)
    (if (and (listp first-key) first-key)
        (setq ret (ac-php--get-clean-node
                   (ac-php--get-key-list-from-parser-data first-key)))
      (if (and items (listp (car items)))
          (setq ret (list (concat first-key "(")))
        (setq ret (list first-key))))
    (while items
      (let ((item (pop items)))
        (cond
         ((and (stringp item)
               items
               (listp (car items)))
          ;; function
          (push (concat item "(") new-items)
          (pop items))
         ((stringp item)
          ;; variable
          (push item new-items)))))
    (nconc ret (nreverse new-items))))

(defun ac-php--tokens-to-parser-data (tokens)
  "Build nested parser data from TOKENS without invoking the Lisp reader."
  (let ((stack (list nil)))
    (dolist (token tokens)
      (cond
       ((string= token "(")
        (push nil stack))
       ((string= token ")")
        ;; Ignore unmatched closing delimiters from an expression prefix.
        (when (cdr stack)
          (let ((node (nreverse (pop stack))))
            (setcar stack (cons node (car stack))))))
       (t
        (setcar stack (cons token (car stack))))))

    ;; Point belongs to the innermost still-open expression.  Close the
    ;; remaining frames into their parents after marking that frame.
    (setcar stack (cons "__POINT__" (car stack)))
    (while (cdr stack)
      (let ((node (nreverse (pop stack))))
        (setcar stack (cons node (car stack)))))
    (nreverse (car stack))))

;; "Remove unnecessary items in the SPLITED-LINE-ITEMS.

;; Used to sanitize auto completion data.  Below are some examples for possible
;; return values:

;;   :-------------------------------:------------------------:
;;   | SPLITED-LINE-ITEMS            | Will return            |
;;   :-------------------------------------------:------------:
;;   | ('foo' '.' 'bar' '(' ')' '.') | ('foo' '.' 'bar(' '.') |
;;   | ('foo' '.' 'bar' '(' 'a')     | ('a')                  |
;;   | ('foo' '.' 'bar')             | ('foo' '.' 'bar')      |
;;   | ('foo' '.')                   | ('foo' '.')            |
;;   | ('foo')                       | ('foo')                |
;;   :-------------------------------:------------------------:

;; Meant for `ac-php-get-class-at-point' .

;; Note: To conveniently describe in the documentation, double quotes (\") have
;; been replaced by '."

(defun ac-php-remove-unnecessary-items-4-complete-method (splited-line-items)
  "Remove unnecessary items in the SPLITED-LINE-ITEMS.

Used to sanitize auto completion data.  Below are some examples for possible
return values:


Meant for `ac-php-get-class-at-point' .

Note: To conveniently describe in the documentation, double quotes (\") have
been replaced by '."
  (ac-php--debug "Start removing unnecessary items for complete method...")
  (ac-php--debug "Intial items are: %S" splited-line-items)
  (let* ((parser-data (ac-php--tokens-to-parser-data splited-line-items))
         (point-node (ac-php--get-node-parser-data parser-data))
         (ret (and point-node
                   (ac-php--get-key-list-from-parser-data point-node))))
    (ac-php--debug "Parser data at point: %S" parser-data)
    (ac-php--debug "The list after removing unnecessary items is: %S" ret)
    ret))

(defun ac-php--get-class-full-name-in-cur-buffer (first-key function-map get-return-type-flag)
  "DOCSTRING FIRST-KEY FUNCTION-MAP GET-RETURN-TYPE-FLAG."
  (let (cur-namespace tmp-name ret-name tmp-ret)
    (let (split-arr cur-class-name)
      (ac-php--debug "ac-php--get-class-full-name-in-cur-buffer first-key:%s" first-key)
      (when (string= "this" first-key)
        (setq  first-key  (ac-php-get-cur-full-class-name)))





      (if (ac-php--check-global-name first-key)
          (setq tmp-name first-key)
        (progn
          (setq split-arr (s-split-up-to "\\\\" first-key 1))
          (ac-php--debug " split-arr 22 len:%d " (length split-arr))

          ;; check for use
          (cond
           ((= 2 (length split-arr))

            (setq cur-namespace (nth 0 split-arr))
            (setq cur-class-name (nth 1 split-arr))
            (setq tmp-name (ac-php-get-use-as-name cur-namespace))
            (ac-php--debug "tmp-name 22 %s" tmp-name)
            (if tmp-name
                (setq tmp-name (concat tmp-name "\\" cur-class-name))
              (setq tmp-name first-key)))

           ((= 1 (length split-arr))
            ;; check use as
            (setq cur-class-name (nth 0 split-arr))
            (setq tmp-name (ac-php-get-use-as-name cur-class-name))
            (unless tmp-name (setq tmp-name first-key))
            (ac-php--debug "XXXX %s " tmp-name)))
          (unless (ac-php--check-global-name tmp-name)
            (let ((tmp-name-as-global (concat "\\" tmp-name))
                  (cur-namepace-tmp-name (concat (ac-php-get-cur-namespace-name) tmp-name)))
              (ac-php--debug " check as cur namespace %s "  cur-namepace-tmp-name )
              (if (ac-php--get-item-from-funtion-map cur-namepace-tmp-name function-map)
                  (setq tmp-name cur-namepace-tmp-name)
                (setq tmp-name tmp-name-as-global))))

          (ac-php--debug "22222 %s " tmp-name))))

    (when tmp-name
      (setq tmp-name (ac-php--as-global-name tmp-name))

      (setq tmp-ret (ac-php--get-item-from-funtion-map tmp-name function-map))
      (ac-php--debug "11 tmp-re %s=> %S" tmp-name tmp-ret)
      (if tmp-ret
          (if get-return-type-flag
              (setq ret-name (aref tmp-ret 4))
            (setq ret-name (aref tmp-ret 1)))))

    (unless ret-name
      (setq tmp-name (if (ac-php--check-global-name first-key) first-key (concat "\\" first-key)))
      (setq tmp-ret (ac-php--get-item-from-funtion-map tmp-name function-map))

      (ac-php--debug "22 tmp-ret %S" tmp-ret)
      (if tmp-ret
          (if get-return-type-flag
              (setq ret-name (aref tmp-ret 4))
            (setq ret-name (aref tmp-ret 1)))))
    ret-name))
;; "This function is used to tokinize PHP string.

;; First this function will split LINE-STRING to small items.

;; For example, suppose LINE-STRING is:

;;   '$class->method($parameter)'

;; then this function split it to:

;;   'class' '.' 'method' '(' 'parameter' ')'

;; Note: To conveniently describe in the documentation, double quotes (\") have
;; been replaced by '."

(defun ac-php-split-line-4-complete-method (line-string)
  "This function is used to tokinize PHP string.

First this function will split LINE-STRING to small items.

For example, suppose LINE-STRING is:

Note: To conveniently describe in the documentation, double quotes (\") have
been replaced by '."
  (ac-php--debug "Start splitting the string to items")
  (save-excursion
    (let ((stack-list nil)
          (old-string line-string))

      ;; "a sequence of characters" => string
      (setq line-string (replace-regexp-in-string
                         "\".*?\"" "string"
                         line-string))

      ;; dot => ;
      (setq line-string (replace-regexp-in-string
                         "[.]" ";"
                         line-string))

      ;; foo:bar => foo;bar
      (setq line-string (replace-regexp-in-string
                         "\\([^:]\\):\\([^:]\\)" "\\1;\\2"
                         line-string))

      ;; class->method => class.method
      (setq line-string (replace-regexp-in-string
                         "[ \t\n\r]*\\??->[ \t\n\r]*" "."
                         line-string) )

      ;; :: => ::.
      (setq line-string (replace-regexp-in-string
                         "[ \t\n\r]*::[ \t\n\r]*" "::."
                         line-string))

      ;; new | return | echo => ;
      (setq line-string (replace-regexp-in-string
                         "\\bnew\\b\\|\\breturn\\b\\|\\becho\\b" ";"
                         line-string))

      ;; case | yield => ;
      (setq line-string (replace-regexp-in-string
                         "\\bcase\\b\\|\\byield\\b" ";"
                         line-string))

      ;; $ => (empty string)
      (setq line-string (replace-regexp-in-string
                         "\\$" ""
                         line-string))

      ;; @ | equal operators => ;
      (setq line-string (replace-regexp-in-string
                         "@\\|!?=>?\\|<=?\\|>=?\\|=" ";"
                         line-string))

      ;; Some operators => ;
      (setq line-string (replace-regexp-in-string
                         "[&|!,?^+/*\-]" ";"
                         line-string))

      (unless (string= old-string line-string)
        (ac-php--debug "Input string was changed during to splitting: \"%s\""
                       line-string))

      ;; Split ‘line-string’ with ".", but add "." as an element at
      ;; its position in list
      (setq stack-list (ac-php-split-string-with-separator
                        line-string "[ \t]*\\.[ \t]*" "." t))

      (let (tmp-list)
        (cl-dolist (ele stack-list)
          (dolist (item (ac-php-split-string-with-separator ele "[{}]" ";" t))
            (push item tmp-list)))
        (setq tmp-list (nreverse tmp-list))
        (setq stack-list tmp-list))

      (let (tmp-list)
        (dolist (ele stack-list)
          (dolist (item (ac-php-split-string-with-separator ele "[>)]\\|]" ")" t))
            (push item tmp-list)))
        (setq tmp-list (nreverse tmp-list))
        (setq stack-list tmp-list))

      (let (tmp-list)
        (dolist (ele stack-list)
          (dolist (item (ac-php-split-string-with-separator ele "[<([]" "(" t))
            (push item tmp-list)))
        (setq tmp-list (nreverse tmp-list))
        (setq stack-list tmp-list))

      (let (tmp-list)
        (dolist (ele stack-list)
          (dolist (item (ac-php-split-string-with-separator ele ";" ";" t))
            (push item tmp-list)))
        (setq tmp-list (nreverse tmp-list))
        (setq stack-list tmp-list))

      (let (tmp-list)
        (dolist (ele stack-list)
          (dolist (item (split-string ele "[ \t]+" t))
            (push item tmp-list)))
        (setq tmp-list (nreverse tmp-list))
        (setq stack-list tmp-list))

      stack-list)))

(defun ac-php-get-syntax-backward (regexp &rest args)
  "Search backward from current point for regular expression REGEXP.

Possible additional ARGS:

    :sexp       Specifies which parenthesized expression in the REGEXP
                should be returned.

    :comment    Indicates should we search inside a comment or not.

    :defun      Indicates should we search inside a defun or not.

    :bound      A buffer position that bounds the search.  The match found must
                not end after that position.  A value of nil means search to the
                end of the accessible portion of the buffer.

Return a propertized string in a format:

  #(\"some string\" 0 11 (pos POINT))

where POINT is a point position that bounds the search.  Return nil in case of
unsuccessful search."
  (let ((found-p nil)
        ret-str
        search-pos
        (sexp (plist-get args :sexp))
        (in-comment-p (plist-get args :comment))
        (in-defun-p (plist-get args :defun))
        (bound (plist-get args :bound)))
    (save-excursion
      (ac-php--debug "Search backward from current point up to %s"
                     (if bound (format "point: %d" bound)
                       "accessible portion of the buffer"))
      (ac-php--debug "Used regular expression: \"%s\"" regexp)
      (while (not found-p)
        (setq search-pos (re-search-backward regexp bound t 1))
        (if search-pos
            ;; Save match data before syntax and defun checks perform their own
            ;; searches.  Re-matching the whole line could otherwise return an
            ;; earlier occurrence than `re-search-backward' found.
            (let ((matched-text (match-string-no-properties sexp))
                  (match-pos (match-beginning 0))
                  (comment-context-ok
                   (if in-comment-p
                       (ac-php--in-comment-p (point))
                     (not (ac-php--in-string-or-comment-p (point))))))
              ;; Rejecting a comment/string match must not trigger an expensive
              ;; function-boundary scan.
              (when (and comment-context-ok
                         (if in-defun-p
                             (ac-php--in-function-p (point))
                           (not (ac-php--in-function-p (point)))))
                (setq ret-str (propertize matched-text 'pos match-pos)
                      found-p t)))
          (setq found-p t))))
    (ac-php--debug "Search result: %s" ret-str)
    ret-str))

(defun ac-php-get-cur-class-name ()
  "Get current class name.

Tries to retrieve current class name if it is possible.
Returns the name of the current class as a string or nil if the search failed."
  (ac-php-get-syntax-backward
   ac-php-re-classlike-pattern
   :sexp 1))

(defun ac-php-get-cur-namespace-name (&optional trim-trailing-backslash-p)
  "Get fully qualified namespace.

Tries to retrieve current fully qualified namespace if it is possible.
TRIM-TRAILING-BACKSLASH-P is used to indicate whether we should trim trailng
backslash or not.  Always returns a string, even if the namespace was not found."
  (let (namespace (not-found ""))
    (setq namespace (ac-php-get-syntax-backward
                     ac-php-re-namespace-pattern
                     :sexp 1))
    (if namespace
        (progn
          ;; Concatenate leading backslash
          (unless (string= (substring namespace 0 1) "\\")
            (setq namespace (concat "\\" namespace)))
          ;; Trim trailng backslash
          (setq namespace (replace-regexp-in-string "\\\\$" "" namespace))
          ;; Add trailing backslash only if needed
          (if (not trim-trailing-backslash-p)
              (setq namespace (concat namespace "\\"))
            namespace))
      not-found)))

(defun ac-php-clean-namespace-name (namespace-name)
  "Doc NAMESPACE-NAME."
  (if (and (stringp namespace-name)
           (> (length namespace-name) 1)
           (string=  (substring-no-properties namespace-name 0 1) "\\"))
      (substring-no-properties namespace-name 1)
    namespace-name))

(defun ac-php-get-cur-full-class-name ()
  "Get current class name in a fully qualified form.
Returns nil if could not find class name in current buffer."
  (let (class-name namespace)
    (setq class-name (ac-php-get-cur-class-name)
          namespace (ac-php-get-cur-namespace-name))
    (if class-name
        (progn
          (when (string= "" namespace)
            (setq namespace "\\"))
          (concat namespace class-name))
      nil)))

(defun ac-php-get-use-as-name (item-name)
  "DOCSTRING ITEM-NAME."
  (let ((item-name (nth 0 (s-split "(" item-name))))
    (or
     (ac-php-get-syntax-backward
      (concat
       "^[ \t]*use[ \t]+\\("
       ac-php-re-namespace-unit-pattern
       "\\\\"
       item-name
       "\\)[ \t]*;")
      :sexp 1)
     (ac-php-get-syntax-backward
      (concat
       "^[ \t]*use[ \t]+\\("
       ac-php-re-namespace-unit-pattern
       "\\)[ \t]+as[ \t]+"
       item-name
       "[ \t]*;")
      :sexp 1))))

(defun ac-php--get-all-use-as-name-in-cur-buffer ()
  "Make a regex to match use statements."
  (let (ret-list (search-re (concat "use[ \t]+" ac-php-re-namespace-unit-pattern ".*;")) line-txt match-ret)
    (save-match-data
      (save-excursion
        (goto-char (point-min))
        (while (re-search-forward search-re nil t)
          (setq line-txt (buffer-substring-no-properties
                          (line-beginning-position)
                          (line-end-position)))
          (ac-php--debug "line-text:%s" line-txt)

          (setq match-ret (s-match (concat "use[ \t]+\\(" ac-php-re-namespace-unit-pattern "\\)[ \t]+as[ \t]+\\(" ac-php-re-namespace-unit-pattern "\\)[ \t]*;") line-txt))
          (if match-ret
              (cl-pushnew (list (ac-php--as-global-name (nth 1 match-ret))
                                (nth 2 match-ret))
                          ret-list :test #'equal)
            (progn
              (setq match-ret (s-match (concat "use[ \t]+\\(" ac-php-re-namespace-unit-pattern "\\)[ \t]*;") line-txt))
              (when match-ret
                (let ((key-arr (s-split "\\\\" (nth 1 match-ret))))
                  (ac-php--debug "key-arr %S " key-arr)

                  (cl-pushnew (list (ac-php--as-global-name (nth 1 match-ret))
                                    (nth (1- (length key-arr)) key-arr))
                              ret-list :test #'equal)))))

          (end-of-line))))
    ret-list))

(defun ac-php-get-annotated-var-class (variable &optional pos)
  "Get a class name for an annotated VARIABLE.

The optional second argument POS specifies current point.  Returns a class
name as a string or nil if the search failed.  At this time doesn't aimed to
work for multi class hint:

/** @var Foo|Bar $baz */"
  (ac-php--debug "Scan for annotated variable")
  ;; TODO: Doesn't aimed to work for multi class hint:
  ;;  /** @var Foo|Bar $baz */
  (let ((in-defun-p (ac-php--in-function-p pos)))
    (ac-php-get-syntax-backward
     (concat ac-php-re-annotated-var-pattern "$" variable "\\b")
     :sexp 1
     :comment t
     :defun in-defun-p
     :bound (when in-defun-p
              (save-excursion (ac-php--beginning-of-defun) (beginning-of-line) (point))))))

(defun ac-php--get-type-hinted-variable-class (variable &optional pos)
  "Return the declared class for VARIABLE at POS.

Recognize typed function parameters, closure imports, and catch variables
within the current function."
  (save-match-data
    (save-excursion
      (goto-char (or pos (point)))
      (when (ac-php--in-function-p)
        (let ((bound (save-excursion
                       (ac-php--beginning-of-defun)
                       (point)))
              (regexp
               (concat "\\(?:^\\|[^a-zA-Z0-9_-ÿ\\\\]\\)"
                       "\\(" ac-php-re-namespace-unit-pattern "\\)"
                       "\\s-+&?\\$" (regexp-quote variable)
                       "\\(?:\\'\\|[^a-zA-Z0-9_-ÿ]\\)"))
              result)
          (while (and (not result) (re-search-backward regexp bound t))
            (let ((type (match-string-no-properties 1))
                  (type-pos (match-beginning 1)))
              ;; The preceding delimiter can be the signature's opening
              ;; parenthesis.  Check scope at the type itself instead.
              (when (and (not (ac-php--in-string-or-comment-p type-pos))
                         (ac-php--in-function-p type-pos))
                (setq result (propertize type 'pos type-pos)))))
          result)))))

(defun ac-php--code-without-comments (start end)
  "Return buffer text from START to END with PHP comments replaced by spaces."
  (save-excursion
    (goto-char start)
    (let ((cursor start)
          chunks)
      (while (re-search-forward "#\\|//\\|/\\*" end t)
        (let* ((comment-start (match-beginning 0))
               (state (syntax-ppss (match-end 0)))
               (syntax-start (nth 8 state)))
          (cond
           ((nth 4 state)
            (push (buffer-substring-no-properties cursor comment-start) chunks)
            (goto-char comment-start)
            (forward-comment 1)
            (setq cursor (min (point) end))
            (goto-char cursor)
            ;; Keep adjacent tokens separate after removing a comment.
            (unless (or (and (> comment-start start)
                             (memq (char-before comment-start)
                                   '(?\s ?\t ?\n ?\r)))
                        (and (< cursor end)
                             (memq (char-after cursor)
                                   '(?\s ?\t ?\n ?\r))))
              (push " " chunks)))
           ((nth 3 state)
            ;; The regexp may occur many times in a URL or literal.  Skip the
            ;; complete string while leaving it in the returned substring.
            (goto-char syntax-start)
            (condition-case nil
                (forward-sexp 1)
              (scan-error (goto-char end)))
            (when (> (point) end)
              (goto-char end))))))
      (push (buffer-substring-no-properties cursor end) chunks)
      (apply #'concat (nreverse chunks)))))

(defun ac-php--expression-bounds-before-point (&optional pos)
  "Return the bounds of the PHP expression ending at POS.

The result is a cons cell (START . END).  Delimiters inside strings, comments,
and nested expressions do not terminate the expression."
  (save-excursion
    (goto-char (or pos (point)))
    (let* ((target (point))
           (target-state (syntax-ppss target))
           (target-depth (car target-state))
           (scan-start
            (or (cl-loop for opener in (nth 9 target-state)
                         when (= (char-after opener) ?\{)
                         maximize (1+ opener))
                (point-min)))
           (expression-start scan-start))
      ;; Usually the first candidate is the preceding statement terminator.
      ;; When a candidate belongs to a string, comment, or deeper expression,
      ;; jump over that entire syntax region instead of inspecting every older
      ;; delimiter in the enclosing block.
      (goto-char target)
      (catch 'boundary-found
        (while (re-search-backward "[;{}]" scan-start t)
          (let* ((delimiter-pos (point))
                 (delimiter (char-after delimiter-pos))
                 (state (syntax-ppss delimiter-pos))
                 (syntax-start (nth 8 state))
                 (delimiter-depth
                  (if (= delimiter ?\})
                      (1- (car state))
                    (car state))))
            (cond
             (syntax-start
              (goto-char (max scan-start syntax-start)))
             ((> delimiter-depth target-depth)
              (let ((opener (car (last (nth 9 state)))))
                (when opener
                  (goto-char (max scan-start opener)))))
             (t
              (setq expression-start (1+ delimiter-pos))
              (throw 'boundary-found t))))))
      (cons expression-start target))))

(defun ac-php--expression-before-point (&optional pos)
  "Return the PHP expression ending at POS, excluding comments.

The nearest valid statement boundary is found before extracting the text."
  (let* ((bounds (ac-php--expression-bounds-before-point pos))
         (expression
          (s-trim
           (ac-php--code-without-comments (car bounds) (cdr bounds)))))
    (when (string-match "<\\?php\\_>" expression)
      (setq expression (substring expression (match-end 0))))
    (s-trim expression)))

(defun ac-php--backward-code-position (pos bound)
  "Move backward from POS over whitespace and comments, stopping at BOUND."
  (save-excursion
    (goto-char pos)
    (condition-case nil
        (forward-comment (- (buffer-size)))
      (scan-error nil))
    (max bound (point))))

(defun ac-php--chain-operator-before (pos bound)
  "Return the member-access operator before POS without crossing BOUND.

The result is a cons cell (OPERATOR . START), or nil."
  (let ((end (ac-php--backward-code-position pos bound)))
    (cond
     ((and (>= (- end bound) 3)
           (string= (buffer-substring-no-properties (- end 3) end) "?->"))
      (cons "?->" (- end 3)))
     ((and (>= (- end bound) 2)
           (member (buffer-substring-no-properties (- end 2) end)
                   '("->" "::")))
      (cons (buffer-substring-no-properties (- end 2) end) (- end 2))))))

(defun ac-php--chain-identifier-before (pos bound)
  "Return the PHP identifier immediately before POS, stopping at BOUND."
  (save-excursion
    (goto-char (ac-php--backward-code-position pos bound))
    (let ((end (point)))
      (skip-syntax-backward "w_" bound)
      ;; Include namespace separators and a possible leading backslash.
      (while (and (> (point) bound) (eq (char-before) ?\\))
        (backward-char)
        (skip-syntax-backward "w_" bound))
      (when (and (> (point) bound) (eq (char-before) ?$))
        (backward-char))
      (when (< (point) end)
        (let* ((start (point))
               (text (buffer-substring-no-properties start end))
               (name (if (string-prefix-p "$" text)
                         (substring text 1)
                       text)))
          (list :kind (if (string-prefix-p "$" text) 'variable 'identifier)
                :name name :text text :start start :end end))))))

(defun ac-php--chain-term-before (pos bound)
  "Return the chain term immediately before POS, stopping at BOUND."
  (let ((end (ac-php--backward-code-position pos bound)))
    (cond
     ((and (> end bound) (eq (char-before end) ?\)))
      (let ((open (condition-case nil (scan-sexps end -1)
                    (scan-error nil))))
        (when (and open (>= open bound) (eq (char-after open) ?\())
          (let ((identifier (ac-php--chain-identifier-before open bound)))
            ;; `<?php\n(...)' is a grouped expression, not a call to `php'.
            ;; Rejecting that partial parse lets the compatibility parser deal
            ;; with parenthesized receivers such as `(new Service())'.  The
            ;; same applies when a control keyword precedes the grouping.
            (when (and identifier
                       (not (member (downcase (plist-get identifier :name))
                                    ac-php--php-key-list))
                       (not (and (string= (plist-get identifier :name) "php")
                                 (>= (- (plist-get identifier :start) bound) 2)
                                 (string=
                                  (buffer-substring-no-properties
                                   (- (plist-get identifier :start) 2)
                                   (plist-get identifier :start))
                                  "<?"))))
              (setq identifier (plist-put identifier :kind 'call))
              (setq identifier
                    (plist-put identifier :arguments (cons open end)))
              (setq identifier (plist-put identifier :end end))
              identifier)))))
     ((and (> end bound) (eq (char-before end) ?\]))
      (let ((open (condition-case nil (scan-sexps end -1)
                    (scan-error nil))))
        (when (and open (>= open bound) (eq (char-after open) ?\[))
          (let ((term (ac-php--chain-term-before open bound)))
            (when term
              (plist-put term :end end)
              term)))))
     (t (ac-php--chain-identifier-before end bound)))))

(defun ac-php--chain-at-point (&optional pos)
  "Return a structured PHP member-access chain ending at POS.

Completed calls are represented in :segments.  The identifier after the last
member-access operator is returned separately as :prefix, so callers can
resolve the receiver independently from the text currently being completed."
  (save-excursion
    (goto-char (or pos (point)))
    (let* ((bounds (ac-php--expression-bounds-before-point (point)))
           (bound (car bounds))
           (target (cdr bounds))
           (prefix-info (ac-php--chain-identifier-before target bound))
           (prefix (and prefix-info (plist-get prefix-info :name)))
           (prefix-start (if prefix-info
                             (plist-get prefix-info :start)
                           target))
           (final-operator
            (ac-php--chain-operator-before prefix-start bound)))
      (when final-operator
        (let ((cursor (cdr final-operator))
              receiver segments failed)
          (while (and (not receiver) (not failed))
            (let ((term (ac-php--chain-term-before cursor bound)))
              (if (not term)
                  (setq failed t)
                (let ((operator
                       (ac-php--chain-operator-before
                        (plist-get term :start) bound)))
                  (if operator
                      (progn
                        (push (list :operator (car operator)
                                    :kind (plist-get term :kind)
                                    :name (plist-get term :name)
                                    :start (plist-get term :start)
                                    :end (plist-get term :end)
                                    :arguments (plist-get term :arguments))
                              segments)
                        (setq cursor (cdr operator)))
                    (setq receiver term))))))
          (when (and receiver (not failed))
            (list :receiver receiver
                  :segments segments
                  :operator (car final-operator)
                  :prefix (or prefix "")
                  :start (plist-get receiver :start)
                  :end target)))))))

(defun ac-php--chain-key-list (chain)
  "Convert structured CHAIN to the legacy key-list representation."
  (let* ((receiver (plist-get chain :receiver))
         (segments (plist-get chain :segments))
         (prefix (plist-get chain :prefix))
         (static-first-p
          (or (and segments
                   (string= (plist-get (car segments) :operator) "::"))
              (and (null segments)
                   (string= (plist-get chain :operator) "::"))))
         (receiver-key
          (concat (plist-get receiver :name)
                  (if (eq (plist-get receiver :kind) 'call) "(" "")
                  (if static-first-p "::" "")))
         (keys (list receiver-key)))
    (dolist (segment segments)
      (setq keys
            (append keys
                    (list "."
                          (concat (plist-get segment :name)
                                  (if (eq (plist-get segment :kind) 'call)
                                      "(" ""))))))
    (setq keys (append keys (list ".")))
    (unless (string= prefix "")
      (setq keys (append keys (list prefix))))
    keys))

(defun ac-php--normalize-callable (expression)
  "Convert an array callable in EXPRESSION to an object method chain."
  (let ((legacy-pattern
         (concat "array[ \t\n]*([ \t\n]*"
                 "\\(\\$[a-z0-9A-Z_> \t-]+\\)[ \t\n]*,"
                 "[ \t\n]*['\"]\\([a-z0-9A-Z_]*\\)"))
        (short-pattern
         (concat "\\[[ \t\n]*"
                 "\\(\\$[a-z0-9A-Z_> \t-]+\\)[ \t\n]*,"
                 "[ \t\n]*['\"]\\([a-z0-9A-Z_]*\\)")))
    (cond
     ((string-match legacy-pattern expression)
      (concat (match-string 1 expression) "->" (match-string 2 expression)))
     ((string-match short-pattern expression)
      (concat (match-string 1 expression) "->" (match-string 2 expression)))
     (t expression))))

(defun ac-php-get-class-at-point (tags-data &optional pos)
  "Resolve the completion chain at POS using TAGS-DATA."
  (save-excursion
    (goto-char (or pos (point)))
    (let ((line-txt (ac-php--expression-before-point)))
      (when (> (length line-txt) 0)
        (ac-php--get-class-at-point tags-data (point) line-txt)))))

(defun ac-php--get-class-at-point (tags-data pos line-txt)
  "Resolve LINE-TXT at POS using TAGS-DATA."
  (let (old-line-txt
        key-list
        first-class-name
        first-key
        first-key-str)
    (ac-php--debug "Current working string: \"%s\"" line-txt)

    (setq old-line-txt line-txt)

    ;; Normalize callable forms like:
    ;;
    ;;   array ($foo, "bar")
    ;;   [$foo, "bar"]
    ;;
    ;; to:
    ;;
    ;;   $foo->bar
    ;;
    (ac-php--debug "Looking for callable forms...")
    (setq line-txt (ac-php--normalize-callable line-txt))

    (if (or (not (ac-php--in-string-or-comment-p pos))
            (not (string= line-txt old-line-txt)))
        (progn
          (if (not (string= line-txt old-line-txt))
              (ac-php--debug "Updated working string: \"%s\"" line-txt))

          (setq key-list
                (or (and (string= line-txt old-line-txt)
                         (let ((chain (ac-php--chain-at-point pos)))
                           (and chain (ac-php--chain-key-list chain))))
                    (ac-php-remove-unnecessary-items-4-complete-method
                     (ac-php-split-line-4-complete-method line-txt))))

          (ac-php--debug "Keyword list is: %S" key-list)
          (if (not (and (stringp (nth 1 key-list))
                        (string= "." (nth 1 key-list))))
              (setq key-list nil)))
      (setq key-list nil))

    (when key-list
      (setq first-key-str (nth 0 (ac-php--get-item-info (nth 0 key-list))))
      (when (and (string-match "::" first-key-str)
                 (not (string-match "\\/\\*" line-txt))
                 (not (string-match "\$[a-zA-Z0-9_]*[\t ]*::" old-line-txt)))
        (progn
          (ac-php--debug "Detected a static method call")
          (setq first-key (substring-no-properties first-key-str 0 -2)
                first-class-name first-key)
          (cond
           ((string= first-key "parent")
            (setq first-class-name (concat (ac-php-get-cur-full-class-name)
                                           ".__parent__")))
           ((or (string= first-key "self")
                (string= first-key "static"))
            (setq first-class-name (concat (ac-php-get-cur-full-class-name)))))))
      (when (not first-class-name)
        (progn

          (if(string-match ".*::" first-key-str)
              (setq first-key (substring-no-properties first-key-str 0 -2))
            (setq first-key first-key-str))

          (when (and (not first-class-name) (string= first-key "this"))
            (ac-php--debug "1Detected call on $this")
            (setq first-class-name (ac-php-get-cur-full-class-name)))

          (ac-php--debug "1Class name is: %s" first-class-name)

          ;; Scan for annotated variable like:
          ;;
          ;;   /** @var Extension $extension */
          ;;
          ;; TODO: Doesn't aimed to work for multi class hint:
          ;;
          ;;  /** @var Foo|Bar $baz */
          ;;
          (unless first-class-name
            (setq first-class-name (ac-php-get-annotated-var-class first-key pos)))

          ;; Scan for function like calls or catch statements like:
          ;;
          ;;   - function hello (Request $request)
          ;;   - function () use (Filter $filter)
          ;;   - catch (\Exception $e)
          ;;
          ;; TODO: Doesn't aimed to work for multi catch exception handling:
          ;;
          ;;   - catch (MyException | MyOtherException $e)
          ;;
          (unless first-class-name
            (ac-php--debug "Scan for funcation like call or a catch statement")
            (setq first-class-name
                  (ac-php--get-type-hinted-variable-class first-key pos))

            ;; not  match return $e->xx;
            (when (string= first-class-name "return" )
              (setq  first-class-name nil)))

          ;; Scan for instanceof :
          ;;
          ;;   - ($e instanceof \Exception)
          ;;
          (unless first-class-name
            (ac-php--debug "Scan for funcation like call or a catch statement")
            (setq first-class-name
                  (ac-php-get-syntax-backward
                   (concat "$\\(" first-key "\\)"
                           "\\s-+instanceof\\s-+\\(" ac-php-re-namespace-unit-pattern "\\)\\s-*[),]")
                   :sexp 2
                   :defun (ac-php--in-function-p pos)
                   :bound (save-excursion
                            (ac-php--beginning-of-defun)
                            (beginning-of-line)
                            (point)))))


          ;; Scan for @param annotation like this:
          ;;
          ;;   @param \Phalcon\Http\Request $request
          ;;
          ;; TODO: @property, @property-read, @property-write
          ;;
          (unless first-class-name
            (ac-php--debug "Scan for method annotations")
            (setq first-class-name
                  (ac-php-get-syntax-backward
                   (concat "@param\\s-+" "\\("
                           ac-php-re-namespace-unit-pattern "\\)\\s-+$" first-key)
                   :sexp 1
                   :comment t
                   :bound (save-excursion (ac-php--beginning-of-defun) (beginning-of-line)))))

          ;; check $v = new .... or $v = $this->sadfa() ;
          (unless first-class-name
            (let (define-str symbol-ret symbol-type)
              (setq define-str
                    (ac-php-get-syntax-backward
                     (concat "$" first-key "\\s-*=\\([^=]*\\)[;]*")
                     :sexp 1
                     :defun (ac-php--in-function-p pos)
                     :bound (save-excursion (ac-php--beginning-of-defun) (beginning-of-line))))
              (when define-str
                (save-excursion
                  (goto-char (get-text-property 0 'pos define-str))
                  (end-of-line)

                  (setq line-txt (buffer-substring-no-properties
                                  (line-beginning-position)
                                  (line-end-position)))

                  (if (string-match "(" line-txt)
                      (let (beginning-of-line-pos temp-key-list search-key)
                        (ac-php--debug "XXXXXX: %s" line-txt)
                        (beginning-of-line)
                        (setq beginning-of-line-pos (point))
                        ;; Function

                        ;; fix: $builder=$this->user->as("tt")->get_sql_builder();
                        (setq temp-key-list (ac-php-remove-unnecessary-items-4-complete-method
                                             (ac-php-split-line-4-complete-method
                                              (replace-regexp-in-string ";[^;]*$" "" line-txt))))

                        ;; (re-search-forward ".[ \t]*(")
                        (setq search-key (s-replace "\\" "\\\\" (s-replace "(" "[ \t]*("
                                                                           (nth (- (length temp-key-list) 1) temp-key-list))))
                        (ac-php--debug "FFFFFFFF: %S" search-key)
                        (re-search-forward search-key)

                        (re-search-backward "[a-zA-Z_0-9][ \t]*(" nil t)
                        (ac-php--debug "XXXXXX: pos22=[%s]"
                                       (buffer-substring-no-properties
                                        beginning-of-line-pos (point))))
                    ;; Property
                    (re-search-backward ".[ \t]*;" nil t))

                  ;; TODO: (backward-char 1)
                  (ac-php--debug "===== define-str :%s pos=%d check_pos=%d"
                                 define-str
                                 (get-text-property 0 'pos define-str)
                                 (point))
                  (setq symbol-ret (ac-php-find-symbol-at-point-pri tags-data))
                  (unless symbol-ret
                    (setq symbol-ret (ac-php-find-symbol-at-point-pri
                                      tags-data nil t)))

                  (when symbol-ret
                    (setq symbol-type (car symbol-ret))
                    (ac-php--debug "XXLLL %s" symbol-type)
                    (when (or (string= symbol-type "class_member")
                              (string= symbol-type "user_function"))
                      (setq first-class-name (nth 2 symbol-ret))
                      )



                    )))))

          (unless first-class-name (setq first-class-name first-key)))))

    ;; fix use-as-name, same namespace
    (when (and first-class-name
               (= 1 (length (s-split "\\." first-class-name))))
      (setq first-class-name
            (ac-php--get-class-full-name-in-cur-buffer
             first-class-name
             (ac-php-g--function-map tags-data) t)))

    (ac-php--debug "22===first-class-name :%s" first-class-name)

    (if first-class-name
        (ac-php--as-global-name
         (apply #'concat first-class-name (cdr key-list)))
      (if (>(length key-list) 1) "null" nil))))


(defun ac-php-candidate-class (tags-data key-str-list)
  "Doc TAGS-DATA KEY-STR-LIST."
  ;; 得到变量
  (let (ret-list output-list class-name
                 (class-map (ac-php-g--class-map tags-data))
                 (inherit-map (ac-php-g--inherit-map tags-data)))
    (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list))
    (setq class-name (ac-php-get-class-name-by-key-list tags-data key-str-list))

    (setq output-list
          (ac-php-get-class-member-list
           class-map inherit-map class-name tags-data))
    (ac-php--debug "22 class-name:%s output-list= %S" class-name output-list)
    (dolist (member output-list)
      (let* ((member-length (length member))
             (member-kind
              (ac-php--get-array-string member member-length 0))
             (key-word (aref member 1)))
        (when (and (string= member-kind "p")
                   (string=
                    (ac-php--get-array-string member member-length 7) "1"))
          (setq key-word (concat "$" key-word)))

        (ac-php--debug "ITEM:%S" member)
        (push
         (propertize
          key-word
          'ac-php-help (ac-php--get-array-string member member-length 2)
          'ac-php-return-type (ac-php--get-array-string member member-length 4)
          'ac-php-tag-type member-kind
          'ac-php-access (ac-php--get-array-string member member-length 6)
          'ac-php-static (ac-php--get-array-string member member-length 7)
          'ac-php-from (ac-php--get-array-string member member-length 5)
          'summary (ac-php--get-array-string member member-length 4))
         ret-list)))

    (ac-php--debug "ret-list = %S" ret-list)
    ret-list))

(defun ac-php--get-item-from-funtion-map (key-word function-map)
  "DOCSTRING KEY-WORD, FUNCTION-MAP."
  (gethash key-word function-map))

(defun ac-php-candidate-other (tags-data)
  "Doc TAGS-DATA."
  (let (ret-list
        (cur-word (ac-php-get-cur-word-without-clean))
        cur-word-len
        start-word-pos
        (function-map (ac-php-g--function-map tags-data))
        key-word
        function-item-len)

    (setq cur-word-len (length cur-word))
    (setq start-word-pos (- cur-word-len (length ac-php-prefix-str)))
    (when (>=  cur-word-len 1)
      ;; user func + class
      (if (string= (substring-no-properties cur-word 0 1) "\\")
          (progn
            (maphash
             (lambda (_k function-item)
               (setq function-item-len (length function-item))
               (when (s-prefix-p cur-word (aref function-item 1) t)
                 (setq key-word (substring-no-properties (aref function-item 1)))

                 (setq key-word (propertize key-word 'ac-php-tag-type
                                            (ac-php--get-array-string function-item function-item-len 0)
                                            ))
                 (setq key-word (propertize key-word 'ac-php-help
                                            (ac-php--get-array-string function-item function-item-len 2)))
                 (setq key-word (propertize key-word 'ac-php-return-type
                                            (ac-php--get-array-string function-item function-item-len 4)))
                 (setq key-word (propertize key-word 'summary
                                            (ac-php--get-array-string function-item function-item-len 4)))
                 (push key-word ret-list))) function-map))
        (let (start-word (word-arr (s-split "\\\\" cur-word)))

          (setq start-word (nth 0 word-arr))
          ;; use as
          (dolist (use-item (ac-php--get-all-use-as-name-in-cur-buffer))
            (ac-php--debug "XXX use-item %s cur-word=%s" use-item cur-word)
            (if (string= start-word cur-word)
                (when (s-prefix-p cur-word (nth 1 use-item) t)
                  (setq key-word (substring-no-properties (nth 1 use-item) start-word-pos))
                  (setq key-word (propertize key-word 'ac-php-tag-type (nth 0 use-item)))
                  (setq key-word (propertize key-word 'ac-php-help (nth 1 use-item)))
                  (setq key-word (propertize key-word 'ac-php-return-type (nth 0 use-item)))
                  (setq key-word (propertize key-word 'summary (nth 0 use-item)))
                  (push key-word ret-list))
              (let (find-now-word find-now-word-len)

                (when (string= start-word (nth 1 use-item))

                  (setq find-now-word (concat (nth 0 use-item)
                                              (substring cur-word (length start-word))))
                  (setq find-now-word-len (length find-now-word))

                  (ac-php--debug "XXX use namespace ... %s %d " find-now-word find-now-word-len)

                  ;; XXXXXXX

                  (maphash
                   (lambda (_k function-item)
                     (setq function-item-len (length function-item))
                     (when(s-prefix-p find-now-word (aref function-item 1) t)
                       (setq key-word
                             (concat
                              cur-word
                              (substring-no-properties (aref function-item 1) find-now-word-len)))

                       (setq key-word (propertize key-word 'ac-php-help
                                                  (ac-php--get-array-string function-item function-item-len 2)))
                       (setq key-word (propertize key-word 'ac-php-return-type
                                                  (ac-php--get-array-string function-item function-item-len 4)))
                       (setq key-word (propertize key-word 'ac-php-tag-type (aref function-item 0)))
                       (setq key-word (propertize key-word 'summary
                                                  (ac-php--get-array-string function-item function-item-len 4)))
                       (push key-word ret-list))) function-map)))))

          ;;; key word
          (dolist (k ac-php--php-key-list)
            (when(and (s-prefix-p cur-word k) (not (string=   k cur-word)))
              (setq key-word k)
              (setq key-word (propertize key-word 'ac-php-help ""))
              (setq key-word (propertize key-word 'ac-php-return-type ""))
              (setq key-word (propertize key-word 'ac-php-tag-type "k"))
              (setq key-word (propertize key-word 'summary ""))
              (push key-word ret-list)))

          ;; cur namespace
          (let ((cur-namespace (ac-php-get-cur-namespace-name)) cur-full-fix start-word-pos-with-namespace)
            (ac-php--debug "XX check cur-namespace === %s" cur-namespace)
            (setq cur-full-fix (concat cur-namespace cur-word))
            (setq start-word-pos-with-namespace (+  start-word-pos (length cur-namespace)))
            (ac-php--debug "check cur-namespace === %s" cur-namespace)


            (maphash
             (lambda (_k function-item)
               (when(s-prefix-p cur-full-fix (aref function-item 1))
                 (setq key-word (substring-no-properties (aref function-item 1) start-word-pos-with-namespace))
                 (setq key-word (propertize key-word 'ac-php-help (aref function-item 2)))
                 (setq key-word (propertize key-word 'ac-php-return-type (aref function-item 4)))
                 (setq key-word (propertize key-word 'ac-php-tag-type (aref function-item 0)))
                 (setq key-word (propertize key-word 'summary (aref function-item 4)))
                 (push key-word ret-list))) function-map))

          ;; system : trim
          (let ((cur-namespace "\\") cur-full-fix start-word-pos-with-namespace)
            (ac-php--debug "XX check cur-namespace === %s" cur-namespace)
            (setq cur-full-fix (concat cur-namespace cur-word))
            (setq start-word-pos-with-namespace (+  start-word-pos (length cur-namespace)))
            (ac-php--debug "check cur-namespace === %s" cur-namespace)


            (maphash
             (lambda (_k function-item)
               (when(s-prefix-p cur-full-fix (aref function-item 1))
                 (setq key-word (substring-no-properties (aref function-item 1) start-word-pos-with-namespace))
                 (setq key-word (propertize key-word 'ac-php-help (aref function-item 2)))
                 (setq key-word (propertize key-word 'ac-php-return-type (aref function-item 4)))
                 (setq key-word (propertize key-word 'ac-php-tag-type (aref function-item 0)))
                 (setq key-word (propertize key-word 'summary (aref function-item 4)))
                 (push key-word ret-list))) function-map))
          ;;; cur function vars
          (maphash
           (lambda (k _v)
             (ac-php--debug " check %s %s " cur-word k)
             (when(and (s-prefix-p cur-word k) (not (string=   k cur-word)))
               (setq key-word k)
               (setq key-word (propertize key-word 'ac-php-help ""))
               (setq key-word (propertize key-word 'ac-php-return-type ""))
               (setq key-word (propertize key-word 'ac-php-tag-type "v"))
               (setq key-word (propertize key-word 'summary ""))
               (push key-word ret-list)))
           (ac-php--get-cur-function-vars)))))
    (ac-php--debug "ret-list:%S" ret-list)
    ret-list))

(defun ac-php--get-cur-function-vars()
  "Doc ."
  (let (txt start-pos end-pos var-list ret-map var-name first-char)
    (save-excursion
      (setq end-pos (- (point) 1))
      (ac-php--beginning-of-defun)
      (setq start-pos (point))
      (setq txt (buffer-substring-no-properties start-pos end-pos))
      (setq var-list (s-match-strings-all "[$\"'][0-9_a-z]*" txt))
      (setq ret-map (make-hash-table :test 'case-fold))
      (dolist (item var-list)
        (setq var-name (nth 0 item))
        (setq first-char (aref var-name 0))
        (when (or (= first-char ?\") (= first-char ?'))
          (setq var-name (substring var-name 1)))

        (puthash var-name nil ret-map))
      ret-map)))

;;; ==============BEGIN
(defun ac-php-find-php-files (project-root-dir regex also-find-subdir)
  "Doc PROJECT-ROOT-DIR. REGEX, ALSO-FIND-SUBDIR get all php file list."
  (let (results sub-results files file-name file-dir-flag file-change-time file-change-unixtime)
    (setq files (directory-files-and-attributes project-root-dir t))
    (dolist (file-item files)
      (setq file-name (nth 0 file-item))
      (setq file-dir-flag (nth 1 file-item))
      (setq file-change-time (nth 6 file-item))

      (if (stringp file-dir-flag);; link
          (setq file-dir-flag (file-directory-p file-dir-flag)))


      (when (and (not file-dir-flag) ;; file
                 (string-match regex file-name))

        (setq file-change-unixtime (+ (* (nth 0 file-change-time) 65536) (nth 1 file-change-time)))
        (if results
            (nconc results (list (list file-name file-change-unixtime)))
          (setq results (list (list file-name file-change-unixtime)))))

      (when (and file-dir-flag
                 ;; (not (string= "." (file-name-base file-name)))
                 ;; (not (string= ".." (file-name-base file-name)))
                 (not (string= "." (substring (file-name-base file-name) 0 1))) ;; not start with "."
                 )
        (when (and also-find-subdir
                   ;; no find in vendor tests
                   (not (s-matches-p "/vendor/.*/tests/" file-name)))
          (setq sub-results (ac-php-find-php-files file-name regex also-find-subdir))

          (if results
              (nconc results sub-results)
            (setq results sub-results)))))
    results))

(defun ac-php--clean-return-type (return-type)
  "Doc RETURN-TYPE."
  (when return-type
    (s-trim (replace-regexp-in-string "|.*" "" return-type))))

(defun ac-php--json-save-data (conf-file data-list)
  "Creating configuration by populating CONF-FILE using DATA-LIST."
  (ac-php--debug "Populate configuration file")

  (let ((old-pp-value json-encoding-pretty-print) json-data)
    (setq json-encoding-pretty-print t
          json-data (json-encode data-list))

    (f-write-text json-data 'utf-8 conf-file)
    (setq json-encoding-pretty-print old-pp-value)))

(defun ac-php--cache-files-save (file-path cache1-files)
  "Doc FILE-PATH CACHE1-FILES."
  (ac-php--json-save-data file-path (list :cache1-files cache1-files)))



(defun ac-php--ctags-opts (project-root-dir rebuild)
  "Create phpctags command options.

This function uses PROJECT-ROOT-DIR as a base path for the project files.  In
addition this function takes into account REBUILD flag which means that the
files should be processed even though they were recently processed (so-called
force rebuild)."
  `(,(concat "--config-file=" (f-join project-root-dir "./" ac-php-config-file))
    ,(concat "--tags_dir=" ac-php-tags-path)
    ,(concat "--rebuild=" (if rebuild "yes" "no"))
    ,(concat "--realpath_flag="
             (if ac-php-project-root-dir-use-truename "yes" "no"))))

(defun ac-php--mago-tags-executable ()
  "Return the executable path for the configured Mago tag generator.
Return nil when `ac-php-mago-tags-executable' cannot be executed."
  (let ((configured ac-php-mago-tags-executable))
    (cond
     ((or (null configured) (s-blank? configured)) nil)
     ((file-name-absolute-p configured)
      (and (file-executable-p configured) configured))
     ((file-name-directory configured)
      (let ((expanded (expand-file-name configured)))
        (and (file-executable-p expanded) expanded)))
     (t (executable-find configured)))))

(defun ac-php--effective-tags-backend ()
  "Return the tag generator backend to use for the current rebuild."
  (pcase ac-php-tags-backend
    ('auto (if (ac-php--mago-tags-executable) 'mago 'phpctags))
    ((or 'mago 'phpctags) ac-php-tags-backend)
    (_ (user-error "Unsupported ac-php tags backend: %S"
                   ac-php-tags-backend))))

(defun ac-php--tags-process-command (project-root-dir rebuild backend)
  "Build the tag generator command for PROJECT-ROOT-DIR.
REBUILD requests a full rebuild and BACKEND selects the generator."
  (pcase backend
    ('mago
     (let ((executable (ac-php--mago-tags-executable)))
       (unless executable
         (user-error "Unable to locate Mago tag generator: %s"
                     ac-php-mago-tags-executable))
       (append
        (list executable
              "--workspace" project-root-dir
              "--config-file" (f-join project-root-dir ac-php-config-file)
              "--output-dir" (ac-php--get-tags-save-dir project-root-dir))
        (when rebuild (list "--rebuild")))))
    ('phpctags
     (append (list ac-php-php-executable ac-php-ctags-executable)
             (ac-php--ctags-opts project-root-dir rebuild)))
    (_ (user-error "Unsupported ac-php tags backend: %S" backend))))

(defun ac-php--rebuild-file-list (project-root-dir rebuild)
  "Indexing project files.

This function uses PROJECT-ROOT-DIR as a base path for the project files.  It
also takes into account REBUILD flag, which means that the files should be
processed even though they were recently processed (so-called force rebuild)."
  (message "ac-php: Rebuild file list...")
  (let* ((backend (ac-php--effective-tags-backend))
         (command (ac-php--tags-process-command
                   project-root-dir rebuild backend))
         (process (apply 'start-process
                         "ac-phptags"
                         "*AC-PHPTAGS*"
                         command)))

    (ac-php--debug "Tag backend: %s; command: %s"
                   backend
                   (mapconcat #'shell-quote-argument command " "))

    (ac-php-mode t)

    (setq ac-php-rebuild-tmp-error-msg nil
          ac-php-phptags-index-progress 0)

    (force-mode-line-update)

    (set-process-sentinel
     process
     #'(lambda (_process event)
         (ac-php-mode 0)
         (cond
          ((string-match "finished" event)
           (if ac-php-rebuild-tmp-error-msg
               (message "ac-php: An error occurred during to re-index: %s"
                        ac-php-rebuild-tmp-error-msg)
             (message "ac-php: The project has been successfully re-indexed")))
          ((string-match "exited abnormally" event)
           (progn
             (message (concat "ac-php: Something went wrong\n"
                              "ac-php: The re-indexing process exited abnormally\n"
                              "ac-php: Please re-check for incorrect syntax and "
                              "possible PHP errors and try again later"))
             (ac-php--debug event))))))

    (set-process-filter process 'ac-php-phptags-index-process-filter)))

(defun ac-php-phptags-index-process-filter (_process strings)
  "Process status update for the indexing process.

This callback function accepts two arguments:

  - _PROCESS, the process that created the output.
  - STRINGS, the message containing the currently produced output."
  (dolist (string (split-string strings "\n"))
    (ac-php--debug "%s" string)
    (cond
     ((string-match "PHPParser:" string)
      (setq ac-php-rebuild-tmp-error-msg
            (concat ac-php-rebuild-tmp-error-msg "\n" string)))
     ((string-match "\\([0-9]+\\)%" string)
      (let ((progress (string-to-number (match-string 1 string))))
        (unless (= ac-php-phptags-index-progress progress)
          (setq ac-php-phptags-index-progress progress)
          (force-mode-line-update)))))))

(defun ac-php--remake-tags (project-root-dir force)
  "Re-index project located at PROJECT-ROOT-DIR taking into account FORCE flag.
This function attempts to re-index project files only if currently no other
process is doing the same."
  (ac-php--debug "Attempting to determine whether need to re-index project...")
  (if (or ac-php-debug-flag ; Force re-index on debug mode
          (not ac-php-gen-tags-flag))
      (progn
        (setq ac-php-gen-tags-flag t)
        (ac-php--remake-tags-ex project-root-dir force))
    (progn
      (ac-php--debug (concat "ac-php: Skip re-indexing project; "
                             "there is already a process that doing the same"))
      nil)))

(defun ac-php--remake-tags-ex (project-root-dir force)
  "Re-index project located at PROJECT-ROOT-DIR taking into account FORCE flag.
This function is used internally by the function `ac-php--remake-tags'."
  (let ((file-name (buffer-file-name))
        (backend (ac-php--effective-tags-backend)))

    ;; Always rebuild tags if currently opened file is from vendor directory
    (when (and file-name (s-match "/vendor/" file-name))
      (setq force t))

    (message "ac-php: Starting to re-index the project located at %s%s"
             (ac-php--reduce-path project-root-dir 60)
             (if force "with a forced rebuilding of all tags" ""))

    (pcase backend
      ('mago
       (unless (ac-php--mago-tags-executable)
         (message "ac-php: Unable to locate Mago tag generator at %s"
                  ac-php-mago-tags-executable)))
      ('phpctags
       (unless (f-exists? ac-php-ctags-executable)
         (message (concat "ac-php: Unable to locate phpctags executable at %s\n"
                          "ac-php: Restarting GNU Emacs might help")
                  ac-php-ctags-executable))

       (unless (and (not (s-blank? ac-php-php-executable))
                    (f-exists? ac-php-php-executable))
         (message (concat "ac-php: Unable to locate PHP executable at %s\n"
                          "ac-php: You need to install PHP CLI and restart GNU Emacs")
                  ac-php-php-executable))))

    (unless project-root-dir
      (message "ac-php: The per-project configuration file '%s' doesn't exist at %s"
               ac-php-config-file
               (file-name-directory (buffer-file-name))))

    (if (and project-root-dir
             (pcase backend
               ('mago (ac-php--mago-tags-executable))
               ('phpctags
                (and (f-exists? ac-php-ctags-executable)
                     (not (s-blank? ac-php-php-executable))
                     (f-exists? ac-php-php-executable)))))
        (progn
          (ac-php--get-tags-save-dir project-root-dir)
          (ac-php--rebuild-file-list project-root-dir force))
      (setq ac-php-gen-tags-flag nil))))

(defun ac-php-gen-el-func (doc)
  "Example doc \"xxx($x1,$x2)\" => $x1 , $x2 DOC."
  (let (func-str)
    (if (string-match "[^(]*(\\(.*\\))[^)]*" doc)
        (progn
          (setq func-str (s-trim (match-string 1 doc)))
          (setq func-str (replace-regexp-in-string "[\t ]*,[\t ]*" "," func-str))
          (setq func-str (replace-regexp-in-string "[\t ]+" " " func-str)))
      "")))

(defun ac-php--get-tags-save-dir (project-root-dir)
  "Get an absolute path to directory where tags should be saved.

This function uses PROJECT-ROOT-DIR as an of path to the directory,
where tags should be saved.  If the directory does not exist, it will
be created."
  (ac-php--debug "Lookup for tags directory...")
  (let (ret tag-dir conf-list old-default-directory)
    (setq conf-list (ac-php--get-config project-root-dir)
          tag-dir (cdr (assoc-string "tag-dir" conf-list)))

    (if tag-dir
        (progn
          (ac-php--debug "Found tags directory")
          (setq old-default-directory default-directory
                default-directory project-root-dir
                ret (file-truename tag-dir)
                default-directory old-default-directory))

      (when (memq system-type '(windows-nt ms-dos))
        ;; Sanitize path: C:\my-project => /C/my-project
        (setq project-root-dir
              (concat "/"
                      (replace-regexp-in-string
                       (regexp-quote ":")
                       ""
                       project-root-dir))))

      (setq ret (concat
                 ac-php-tags-path
                 "/tags"
                 (replace-regexp-in-string
                  (regexp-quote "/") "-"
                  (replace-regexp-in-string "[/\\]*$" "" project-root-dir)))))

    (unless (f-exists? ret)
      (mkdir ret t))
    (f-full ret)))

(defun ac-php-get-tags-file ()
  "Get the actual project's tag file.

Returns a list where the 1st element will be a real path to the project,
and the 2nd element will be the a real path to the tags file.  Will return
nil when unable to read tags file.

This function checks for modification time of the procject's tags file.
If it is outdated, a re-index process will be performed."
  (ac-php--debug "Retrieving tags file...")
  (let ((project-root-dir (ac-php--get-project-root-dir))
        tags-file
        tags-vendor-file
        file-attr
        file-last-time
        tags-save-dir
        now)
    (if project-root-dir
        (progn
          (setq
           tags-save-dir  (ac-php--get-tags-save-dir project-root-dir)
           tags-file (concat tags-save-dir "tags.el")
           tags-vendor-file (concat tags-save-dir "tags-vendor.el")
           file-attr (file-attributes tags-file)
           )

          (when file-attr
            (progn
              (ac-php--debug "Found tags file")
              (setq file-last-time (ac-php--get-timestamp (nth 5 file-attr))
                    now (ac-php--get-timestamp (current-time))))

            (when (and (> (- now file-last-time) ac-php-auto-update-intval))
              (progn
                (ac-php--debug "The tags file is out of date")
                (ac-php--remake-tags project-root-dir nil))))

          (list project-root-dir tags-file tags-vendor-file ))
      nil)))

(defun ac-php--get-config-path-noti-str (project-root-dir path-str)
  "Doc PATH-STR PROJECT-ROOT-DIR."
  (if (s-ends-with? "*.php" path-str)
      (format "php-path-list-without-subdir->%s" (f-relative (f-parent path-str) project-root-dir))
    (format "php-path-list->%s" (f-relative path-str project-root-dir))))

(defun ac-php--get-config (project-root-dir)
  "Get configuration related to a project.

Reads the configuration located at PROJECT-ROOT-DIR and returns it.
This function tries to recreate and / or populate configuration
file in case of its absence, or if it is empty."
  (ac-php--debug "Lookup for per-project configuration file...")
  (let (config-file-name)
    (setq config-file-name (f-join project-root-dir ac-php-config-file))

    ;; Lookup for `ac-php-config-file'
    (when (and
           (not (s-starts-with-p "/ssh:" config-file-name))
           (not (s-starts-with-p "/server:" config-file-name))
           (or (not (f-exists? config-file-name))
               (= (f-size config-file-name) 0)
               ;; Use case for "echo '' > `config-file-name'"
               (= (f-size config-file-name) 1)))
      (ac-php--debug "Configuration file either empty or absent. Creating...")
      (ac-php--json-save-data
       config-file-name
       '(:use-cscope nil
                     :tag-dir nil
                     :filter (
                              :php-file-ext-list ("php")
                              :php-path-list (".")
                              :ignore-ruleset (
                                               "# like .gitignore file "
                                               "/vendor/**/[tT]ests/**/*.php"
                                               "/vendor/**/[Ee]xamples/**/*.php"
                                               "/vendor/composer/*.php"
                                               "/vendor/*.php"

                                               "# not need php_codesniffer"
                                               "/vendor/squizlabs/php_codesniffer/**/*.php"

                                               "#  -- end -- "

                                               )))))
    (json-read-file config-file-name)))

(defun ac-php--get-use-cscope-from-config-file (project-root-dir)
  "Doc PROJECT-ROOT-DIR."
  (let (conf-list)
    (setq conf-list (ac-php--get-config project-root-dir))
    (cdr (assoc-string "use-cscope" conf-list))))


(defun ac-php-remake-tags ()
  "Reset tags, if php source is changed."
  (interactive)
  (ac-php--remake-tags (ac-php--get-project-root-dir) nil))

(defun ac-php-remake-tags-all ()
  "Remake tags without check modify time."
  (interactive)
  (ac-php--remake-tags (ac-php--get-project-root-dir) t))

(defun ac-php--remake-cscope (project-root-dir all-file-list)
  "DOCSTRING, PROJECT-ROOT-DIR, ALL-FILE-LIST."
  (let (tags-dir-len save-dir)
    (when (and ac-php-cscope
               (or (ac-php--get-use-cscope-from-config-file project-root-dir)
                   ac-php-use-cscope-flag))
      (ac-php--debug "ac-php--remake-cscope %d" (length all-file-list))
      (message "rebuild cscope data file ")
      (setq tags-dir-len (length project-root-dir))
      ;; write cscope.files
      (setq save-dir (ac-php--get-tags-save-dir project-root-dir))
      (let ((file-name-list) cscope-file-name)
        (dolist (file-item all-file-list)
          (setq cscope-file-name (concat project-root-dir (substring (nth 0 file-item) tags-dir-len)))
          (push cscope-file-name file-name-list))
        (f-write
         (s-join "\n" file-name-list)
         'utf-8
         (concat save-dir "cscope.files")))
      (shell-command-to-string
       (concat " cd " save-dir " &&  cscope -bkq -i cscope.files ")))))

(defun ac-php--get-obj-tags-dir(save-tags-dir)
  "Doc SAVE-TAGS-DIR."
  (concat save-tags-dir "/tags_dir_" (getenv "USER") "/"))

(defun ac-php--get-obj-tags-file-list(save-tags-dir)
  "DOCSTRING SAVE-TAGS-DIR."
  (let ((obj-tags-dir (ac-php--get-obj-tags-dir save-tags-dir)))
    (if (not (file-directory-p obj-tags-dir))
        (mkdir obj-tags-dir t))
    (ac-php-find-php-files obj-tags-dir "\\.el$" t)))

(defun ac-php-save-data (file data)
  "Doc FILE. DATA."
  (message "save to %s ..." file)
  ;; (f-write (format "%S" data) 'utf-8 file)
  (with-temp-file file
    (let ((standard-output (current-buffer))
          (print-circle t) ; Allow circular data
          )
      (prin1 data))))
(defun case-fold-string= (a b)
  "Doc A B."
  (eq t (compare-strings a nil nil b nil nil t)))
(defun case-fold-string-hash (a)
  "Doc A."
  (sxhash (upcase a)))

(define-hash-table-test 'case-fold
                        'case-fold-string= 'case-fold-string-hash)

(defun ac-php--tags-cache ()
  "Return the tags cache, resetting data stored in the legacy alist format."
  (unless (and (hash-table-p ac-php-tag-last-data-list)
               (eq (hash-table-test ac-php-tag-last-data-list) 'equal))
    ;; Entries from the old alist do not contain the vendor signature and are
    ;; therefore unsafe to reuse.  They will be loaded lazily into the new cache.
    (setq ac-php-tag-last-data-list (make-hash-table :test #'equal)))
  ac-php-tag-last-data-list)

(defun ac-php--tags-file-signature (file)
  "Return a cache signature for FILE, or nil when FILE does not exist."
  (when file
    (let ((attributes (file-attributes file)))
      (when attributes
        ;; Keep complete times instead of reducing them to whole seconds.  The
        ;; file identity catches atomic replacement, while size catches common
        ;; replacements on file systems with coarse timestamp resolution.
        (list (nth 5 attributes)
              (nth 6 attributes)
              (nth 7 attributes)
              (nth 10 attributes)
              (nth 11 attributes))))))

(defun ac-php-load-data (tags-file tags-vendor-file project-root-dir)
  "Return the autocompleted data for the project.

This function tries to use the `ac-php-tag-last-data-list' variable to query the
necessary data.  The `ac-php-tag-last-data-list' is used as a temporary
in-memory storage of all the tags.

TAGS-FILE and TAGS-VENDOR-FILE are both checked for changes.  If either file
changes, the merged data for PROJECT-ROOT-DIR is rebuilt and cached."
  (let* ((cache (ac-php--tags-cache))
         (cache-key (expand-file-name tags-file))
         (vendor-key (and tags-vendor-file
                          (expand-file-name tags-vendor-file)))
         (tags-signature (ac-php--tags-file-signature cache-key))
         (vendor-signature (ac-php--tags-file-signature vendor-key))
         (cached-entry (gethash cache-key cache))
         file-data
         vendor-tags-data
         class-map
         function-map
         inherit-map
         tags-data
         g-ac-php-tmp-tags)
    (if (not tags-signature)
        (progn
          (remhash cache-key cache)
          nil)
      (if (and cached-entry
               (equal tags-signature (plist-get cached-entry :signature))
               (equal vendor-key (plist-get cached-entry :vendor-file))
               (equal vendor-signature
                      (plist-get cached-entry :vendor-signature))
               (equal project-root-dir
                      (plist-get cached-entry :project-root-dir)))
          (plist-get cached-entry :data)
        (message (concat "ac-php: Reloading the autocompletion "
                         "data from the tags file..."))

        ;; `g-ac-php-tmp-tags' will be populated from the generated file.
        (setq vendor-tags-data
              (list (make-hash-table :test 'case-fold)
                    (make-hash-table :test 'case-fold)
                    (make-hash-table :test 'case-fold)
                    []))
        (when vendor-signature
          (setq vendor-tags-data
                (ac-php-load-data vendor-key nil project-root-dir)))

        (load cache-key nil t)
        (setq file-data g-ac-php-tmp-tags
              class-map
              (copy-hash-table (ac-php-g--class-map vendor-tags-data))
              function-map
              (copy-hash-table (ac-php-g--function-map vendor-tags-data))
              inherit-map
              (copy-hash-table (ac-php-g--inherit-map vendor-tags-data)))

        ;; The generated `file-data' is an array containing class, function and
        ;; inheritance entries followed by the indexed file list.
        (mapc
         (lambda (class-item)
           (puthash (format "%s" (car class-item)) (cdr class-item) class-map))
         (aref file-data 0))

        (mapc
         (lambda (function-item)
           (ac-php--debug "add function: %s" (aref function-item 1))
           (puthash (aref function-item 1) function-item function-map))
         (aref file-data 1))

        (mapc
         (lambda (inherit-item)
           (puthash (format "%s" (car inherit-item))
                    (cdr inherit-item) inherit-map))
         (aref file-data 2))

        (setq tags-data
              (list class-map
                    function-map
                    inherit-map
                    (vconcat (ac-php-g--file-list vendor-tags-data)
                             (aref file-data 3))
                    project-root-dir))
        (puthash cache-key
                 (list :signature tags-signature
                       :vendor-file vendor-key
                       :vendor-signature vendor-signature
                       :project-root-dir project-root-dir
                       :data tags-data)
                 cache)
        (message "ac-php: Reloading has been successfully finished")
        tags-data))))

(defun ac-php-g--class-map (tags-data)
  "Doc TAGS-DATA."
  (nth 0 tags-data))
(defun ac-php-g--function-map (tags-data)
  "Doc TAGS-DATA."
  (nth 1 tags-data))
(defun ac-php-g--inherit-map (tags-data)
  "Doc TAGS-DATA."
  (nth 2 tags-data))
(defun ac-php-g--file-list (tags-data)
  "Doc TAGS-DATA."
  (nth 3 tags-data))

(defun ac-php-get-tags-data ()
  "Load a tags data for the particular project."
  (let (tags-file tags-vendor-file project-root-dir (tags-definition (ac-php-get-tags-file)))
    (if tags-definition
        (progn
          (setq
           project-root-dir (nth 0 tags-definition)
           tags-file (nth 1 tags-definition)
           tags-vendor-file (nth 2 tags-definition)
           ))
      (setq tags-file (ac-php--get-common-json-file))
      (unless(f-exists?  tags-file )
        ;;gen
        (shell-command-to-string
         (concat  ac-php-php-executable " " ac-php-ctags-executable " "
                  "--save-common-el=" tags-file
                  )
         ))
      )
    (ac-php--debug "Loading tags file: %s" (ac-php--reduce-path tags-file 60))
    (if (and  (file-exists-p tags-file )
              (or (not tags-vendor-file) (file-exists-p tags-vendor-file ) ) )
        (ac-php-load-data tags-file tags-vendor-file  project-root-dir )
      (progn
        (ac-php--debug (concat "The per-project tags file doesn't exist. "
                               "Starting create a new one..."))
        (ac-php-remake-tags)))))

(defun ac-php--get-project-root-dir ()
  "Get the project root directory of the curent opened buffer."
  (ac-php--debug "Lookup for the project root...")
  (let (project-root-dir (file-name buffer-file-name))

    ;; 1. Get working directory using `buffer-file-name' or `default-directory'
    (if file-name
        (setq project-root-dir (file-name-directory file-name))
      (setq project-root-dir (expand-file-name default-directory)))

    ;; 2. Expand real path of the obtained working directory (if enabled)
    (when ac-php-project-root-dir-use-truename
      (setq project-root-dir (file-truename project-root-dir)))

    ;; 3. Scan for the real project root of the opend file
    ;; We're looking either for the `ac-php-config-file' file
    ;; or the '.projectile' file, or the 'vendor/autoload.php' file
    (let (last-dir)
      (while
          (not (or
                (file-exists-p (concat project-root-dir ac-php-config-file))
                (file-exists-p (concat project-root-dir ".projectile"))
                (file-exists-p (concat project-root-dir "vendor/autoload.php"))
                (string= project-root-dir "/")))
        (setq last-dir project-root-dir
              project-root-dir (file-name-directory
                                (directory-file-name project-root-dir)))
        (when (string= last-dir project-root-dir)
          (setq project-root-dir "/"))))

    (when (string= project-root-dir "/")
      (progn
        (message "ac-php: Unable to resolve project root")
        (setq project-root-dir nil)))

    project-root-dir))

(defconst ac-php--class-cache-miss (make-symbol "ac-php-class-cache-miss")
  "Sentinel used for class lookup cache misses.")

(defvar ac-php--class-lookup-caches
  (make-hash-table :test #'eq :weakness 'key)
  "Weak cache of class lookup data, keyed by a tags data generation.")

(defun ac-php--get-class-lookup-cache (tags-data)
  "Return the lazy class lookup cache for TAGS-DATA.

The cache is scoped to the identity of TAGS-DATA.  Loading a new tags
generation creates a new data object, while the weak key lets obsolete
generations be reclaimed.  The cache vector contains inheritance orders,
direct member indexes, and flattened member lists, respectively."
  (when tags-data
    (or (gethash tags-data ac-php--class-lookup-caches)
        (let ((cache (vector (make-hash-table :test #'equal)
                             (make-hash-table :test #'equal)
                             (make-hash-table :test #'equal))))
          (puthash tags-data cache ac-php--class-lookup-caches)
          cache))))

(defun ac-php--resolve-inherited-class-name
    (class-name parent-namespace class-map)
  "Resolve CLASS-NAME relative to PARENT-NAMESPACE using CLASS-MAP."
  (when (stringp class-name)
    (if (ac-php--check-global-name class-name)
        class-name
      (let ((qualified-name
             (concat (or parent-namespace "") "\\" class-name))
            (global-name (concat "\\" class-name)))
        (cond
         ((gethash qualified-name class-map) qualified-name)
         ((gethash global-name class-map) global-name))))))

(defun ac-php--get-check-class-list
    (class-name inherit-map class-map &optional tags-data)
  "Return the depth-first class order for CLASS-NAME.

INHERIT-MAP and CLASS-MAP provide the graph.  Each resolved class occurs at
most once, so cycles and shared ancestors cannot expand the result.  When
TAGS-DATA is supplied, cache the result for that tags generation."
  (let* ((namespace (ac-php-get-cur-namespace-name t))
         (cache (ac-php--get-class-lookup-cache tags-data))
         (order-cache (and cache (aref cache 0)))
         (cache-key (cons (downcase (or class-name ""))
                          (downcase (or namespace ""))))
         (cached (and order-cache
                      (gethash cache-key order-cache
                               ac-php--class-cache-miss))))
    (if (and order-cache (not (eq cached ac-php--class-cache-miss)))
        cached
      (let ((stack (list (list 'enter class-name namespace)))
            (states (make-hash-table :test #'equal))
            result)
        (while stack
          (let ((entry (pop stack)))
            (if (eq (car entry) 'exit)
                (let ((resolved-name (nth 1 entry))
                      (visited-key (nth 2 entry)))
                  (puthash visited-key 'done states)
                  ;; Reverse postorder keeps every descendant before its
                  ;; ancestors while retaining declared branch priority.
                  (push resolved-name result))
              (let* ((resolved-name
                      (ac-php--resolve-inherited-class-name
                       (nth 1 entry) (nth 2 entry) class-map))
                     (visited-key
                      (and resolved-name (downcase resolved-name))))
                (when (and resolved-name
                           (not (gethash visited-key states)))
                  (puthash visited-key 'visiting states)
                  (push (list 'exit resolved-name visited-key) stack)
                  (let ((parents (gethash resolved-name inherit-map))
                        (parent-namespace
                         (ac-php--get-namespace-from-classname resolved-name)))
                    ;; Stack order is reversed again by postorder, preserving
                    ;; the order in which parents were declared.
                    (dotimes (index (length parents))
                      (push (list 'enter (aref parents index)
                                  parent-namespace)
                            stack))))))))
        (when order-cache
          (puthash cache-key result order-cache))
        (ac-php--debug "XXXX check-class list:%S" result)
        result))))

(defun ac-php--check-global-name(name)
  "Doc NAME."
  (s-prefix-p "\\" name))


(defun ac-php--as-global-name(name)
  "Doc NAME."
  (if (ac-php--check-global-name name)
      name
    (concat "\\" name)))

(defun ac-php--get-item-info (member)
  "Recognize current MEMBER type.

This function tries to determine whether passed MEMBER is a method or a
property.  Return a cons cell `(MEMBER . TYPE)' where TYPE will be either
\"m\" (method) or \"p\" (property).

Note that this function does not perform in-depth analysis and its main task is
to determine whether the current MEMBER is a \"method call\".
All other cases are considered at this stage as a \"property usage\",
although in fact they may not be."
  (ac-php--debug "Recognize current member type")
  (let (type-str)
    (if (and (> (length member) 1) (string= "(" (substring member -1)))
        (progn
          (setq type-str "m"))
      (setq type-str "p"))
    (list member type-str)))


(defun ac-php--class-member-key (member-info)
  "Return the override key for MEMBER-INFO.

PHP method names are case-insensitive.  Property and constant names are
case-sensitive, and the tag kind remains part of the key so different member
kinds can coexist."
  (let ((kind (aref member-info 0))
        (name (aref member-info 1)))
    (cons kind (if (string= kind "m") (downcase name) name))))

(defun ac-php--class-member-lookup-key (kind name)
  "Return a lookup key for member KIND and NAME."
  (if (string= kind "m")
      (cons "m" (downcase name))
    (cons "value" name)))

(defun ac-php--get-direct-member-index (class-map class-name cache)
  "Return direct member indexes for CLASS-NAME in CLASS-MAP.

CACHE is the optional generation-scoped direct-index cache.  The returned
cons contains a lookup index and an exact override index.  Later definitions
in one class replace earlier definitions."
  (let ((cached (and cache
                     (gethash class-name cache ac-php--class-cache-miss))))
    (if (and cache (not (eq cached ac-php--class-cache-miss)))
        cached
      (let* ((members (gethash class-name class-map))
             (member-count (length members))
             (lookup-index
              (make-hash-table :test #'equal :size (max 1 member-count)))
             (override-index
              (make-hash-table :test #'equal :size (max 1 member-count))))
        (dotimes (index (length members))
          (let* ((member-info (aref members index))
                 (kind (aref member-info 0))
                 (name (aref member-info 1)))
            (puthash (ac-php--class-member-lookup-key kind name)
                     member-info lookup-index)
            (puthash (ac-php--class-member-key member-info)
                     member-info override-index)))
        (setq cached (cons lookup-index override-index))
        (when cache
          (puthash class-name cached cache))
        cached))))

(defun ac-php-get-class-member-info
    (class-map inherit-map class-name member &optional tags-data)
  "Return MEMBER information for CLASS-NAME.

CLASS-MAP and INHERIT-MAP provide the class graph.  TAGS-DATA enables lazy
indexes scoped to the loaded tags generation."
  (let* ((class-order
          (ac-php--get-check-class-list
           class-name inherit-map class-map tags-data))
         (item-info (ac-php--get-item-info member))
         (member-name (nth 0 item-info))
         (member-kind (nth 1 item-info))
         (lookup-key
          (ac-php--class-member-lookup-key member-kind member-name))
         (cache (ac-php--get-class-lookup-cache tags-data))
         (direct-cache (and cache (aref cache 1)))
         result)
    (while (and class-order (not result))
      (let ((indexes
             (ac-php--get-direct-member-index
              class-map (pop class-order) direct-cache)))
        (setq result (gethash lookup-key (car indexes)))))
    (ac-php--debug "ac-php-get-class-member-info ret=%S" result)
    result))

(defun ac-php-get-class-member-list
    (class-map inherit-map class-name &optional tags-data)
  "Return effective members for CLASS-NAME.

Child definitions override inherited definitions with the same kind and name.
Method names compare case-insensitively; other member names compare exactly.
TAGS-DATA enables generation-scoped lazy indexes and result caching."
  (let* ((class-order
          (ac-php--get-check-class-list
           class-name inherit-map class-map tags-data))
         (cache (ac-php--get-class-lookup-cache tags-data))
         (direct-cache (and cache (aref cache 1)))
         (member-list-cache (and cache (aref cache 2)))
         (cache-key (downcase (or (car class-order) class-name "")))
         (cached (and member-list-cache
                      (gethash cache-key member-list-cache
                               ac-php--class-cache-miss))))
    (if (and member-list-cache
             (not (eq cached ac-php--class-cache-miss)))
        cached
      (let ((seen (make-hash-table :test #'equal))
            result)
        (dolist (current-class class-order)
          (let* ((members (gethash current-class class-map))
                 (indexes
                  (ac-php--get-direct-member-index
                   class-map current-class direct-cache))
                 (override-index (cdr indexes)))
            (dotimes (index (length members))
              (let* ((member-info (aref members index))
                     (member-key (ac-php--class-member-key member-info)))
                (when (and (eq member-info (gethash member-key override-index))
                           (not (gethash member-key seen)))
                  (puthash member-key t seen)
                  (push member-info result))))))
        (setq result (nreverse result))
        (when member-list-cache
          (puthash cache-key result member-list-cache))
        result))))

(defun ac-php--get-class-name-from-parent-define(parent-list-str)
  "D '\\Class1,interface1' => Class1 PARENT-LIST-STR."
  (s-trim (aref (s-split "," parent-list-str) 1)))

(defun ac-php--resolve-member-return-type (return-type receiver-class)
  "Resolve RETURN-TYPE relative to RECEIVER-CLASS.

`self', `static', and PHPDoc's `$this' describe the object on which the
member was resolved.  They can also occur inside compound types such as
`ServiceBase&static'.  The completion engine follows one class at a time, so
keep the receiver class when any of these late-bound types is present."
  (if (and (stringp return-type)
           (stringp receiver-class)
           (or (string-match-p
                "\\b\\(?:self\\|static\\)\\b" return-type)
               (string-match-p "\\$this\\b" return-type)))
      receiver-class
    return-type))

(defun ac-php-get-class-name-by-key-list(tags-data key-list-str)
  "D TAGS-DATA KEY-LIST-STR."
  (let (temp-class (cur-class "")
                   (class-map (ac-php-g--class-map tags-data))
                   (inherit-map (ac-php-g--inherit-map tags-data))
                   (key-list (split-string key-list-str "\\.")))
    (ac-php--debug "====XXKK:%S" key-list)
    (cl-loop for item in key-list do
             (if (string= cur-class "")
                 (if (or (gethash item inherit-map) (gethash item class-map))
                     (setq cur-class item)
                   (cl-return))
               (progn
                 (setq temp-class cur-class)

                 (if (string= item "__parent__")
                     (let (parent-list)
                       (setq parent-list (gethash cur-class inherit-map))

                       (ac-php--debug "XXKK:%S " parent-list)

                       (if parent-list
                           (setq cur-class (aref parent-list 0))
                         (setq cur-class "")))

                   (let (member-info)
                     (setq member-info
                           (ac-php-get-class-member-info
                            class-map inherit-map cur-class item tags-data))
                     (setq cur-class (if member-info
                                         (let (tmp-class cur-namespace relative-classname member-local-class-name)
                                           (setq tmp-class
                                                 (ac-php--resolve-member-return-type
                                                  (aref member-info 4)
                                                  cur-class))
                                           (ac-php--debug "tmp-class %s member-info:%S" tmp-class member-info)
                                           (when (stringp tmp-class)
                                             (if (ac-php--check-global-name tmp-class)
                                                 ;;  global name, like \test\ss
                                                 tmp-class
                                               (progn;; tmp-class like test\ss
                                                 ;; relative name, MUST be resolved relatively as \cur-namespace\test\ss
                                                 (setq member-local-class-name (aref member-info 5))
                                                 (setq cur-namespace (ac-php--get-namespace-from-classname member-local-class-name))
                                                 (setq relative-classname (concat cur-namespace "\\" tmp-class))
                                                 (ac-php--debug " 2 relative-classname %s " relative-classname)
                                                 relative-classname))))
                                       ""))))

                 (when (string= cur-class "")
                   (message (concat " class[" temp-class "]'s member[" item "] not define type "))
                   (cl-return)))))
    cur-class))

(defun ac-php--get-namespace-from-classname (classname)
  "D CLASSNAME."
  (nth 1 (s-match "\\(.*\\)\\\\[a-zA-Z0-9_]+$" classname)))

(defun ac-php-find-symbol-at-point-pri (tags-data &optional as-fn-p as-id-p)
  "Docstring. TAGS-DATA AS-FN-P AS-ID-P."
  (let (key-str-list
        cur-word
        ret)

    ;; TODO: How about new line
    (if as-id-p
        (setq cur-word (ac-php--get-cur-word))
      (if as-fn-p
          (setq cur-word (concat (ac-php--get-cur-word) "("))
        (setq cur-word (ac-php--get-cur-word-with-function-flag))))

    (when cur-word
      (ac-php--debug "Current working string: \"%s\"" cur-word))

    (setq key-str-list (ac-php-get-class-at-point tags-data))

    (ac-php--debug "key-str-list==end:%s" key-str-list)

    (if key-str-list
        (progn
          (let (class-name member-info)
            ;; (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" (concat "." cur-word) key-str-list))
            (when (string= cur-word "")
              (let ((key-arr (s-split "\\." key-str-list)))
                (ac-php--debug "key-arr %S " key-arr)
                (setq cur-word (nth (1- (length key-arr)) key-arr))))

            (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list))
            (ac-php--debug "class. key-str-list = %s " key-str-list)
            (setq class-name (ac-php-get-class-name-by-key-list tags-data key-str-list))

            (ac-php--debug "class.member= %s.%s " class-name cur-word)
            (if (not (string= class-name ""))
                (progn
                  (setq member-info
                        (ac-php-get-class-member-info
                         (ac-php-g--class-map tags-data)
                         (ac-php-g--inherit-map tags-data)
                         class-name cur-word tags-data))
                  (if member-info
                      (progn
                        (let (return-type)
                          (setq return-type
                                (ac-php--resolve-member-return-type
                                 (aref member-info 4) class-name))
                          (setq ret (list "class_member" (aref member-info 3) return-type member-info)))

                        )
                    (progn
                      (message "no find %s.%s " class-name cur-word))))
              ;; (message "no find class from key-list %s " key-str-list)
              )))
      (progn ;; function
        (let ((function-map (ac-php-g--function-map tags-data))
              full-name tmp-ret)

          (when (string= "" cur-word) ;; new
            (setq tmp-ret (ac-php-get-syntax-backward
                           (concat "new[ \t]+\\(" ac-php-re-namespace-unit-pattern "\\)")
                           :sexp 1))
            (when tmp-ret (setq cur-word tmp-ret)))
          ;; check "namespace" "use as"
          (setq full-name (ac-php--get-class-full-name-in-cur-buffer
                           cur-word
                           function-map nil))

          (when full-name (setq cur-word full-name))

          ;; TODO FIX namespace function like Test\ff()
          (ac-php--debug "check user function===%s" cur-word)
          (when (string=  cur-word "self")
            (setq cur-word (concat (ac-php-get-cur-class-name))))

          (let (function-item)
            (setq function-item (ac-php--get-item-from-funtion-map cur-word function-map))
            (when function-item
              (setq ret (list "user_function" (aref function-item 3) (aref function-item 4) function-item)))))))

    (ac-php--debug "ac-php-find-symbol-at-point-pri :%S " ret)
    ret))

(defun ac-php--goto-local-var-def (local-var)
  "D goto LOCAL-VAR like vim - gd."
  (ac-php--debug "local-var %s " local-var)
  (ac-php-location-stack-push)
  (ac-php--beginning-of-defun)

  (re-search-forward (concat "\\" local-var "\\b")) ; => \\$var\\b
  (while (ac-php--in-string-or-comment-p (point))
    (re-search-forward (concat "\\" local-var "\\b")))) ; => \\$var\\b

(defun ac-php-find-symbol-at-point (&optional _prefix)
  "D PREFIX."
  (interactive "P")
  ;; 检查是类还是 符号
  (let ((tags-data (ac-php-get-tags-data))
        symbol-ret type jump-pos local-var local-var-flag)
    (setq local-var (ac-php-get-cur-word-with-dollar))
    (setq local-var-flag (s-matches-p "^\\$" local-var))

    (setq symbol-ret (or (ac-php--named-argument-symbol tags-data)
                         (ac-php-find-symbol-at-point-pri tags-data)))

    (ac-php--debug "11goto %s" symbol-ret)
    (unless symbol-ret
      (setq symbol-ret (ac-php-find-symbol-at-point-pri tags-data t)))
    (ac-php--debug "22goto %s" symbol-ret)
    (unless symbol-ret
      (setq symbol-ret (ac-php-find-symbol-at-point-pri tags-data nil t)))
    (ac-php--debug "33goto %s %s" symbol-ret local-var-flag)

    (if symbol-ret
        (progn
          (ac-php--debug "goto %s" symbol-ret)
          (setq type (car symbol-ret))
          (if (and (not (string= type "class_member")) local-var-flag)
              (let ((item-info (nth 3 symbol-ret)))
                (if (string=  (nth 0 item-info) "v")
                    (progn
                      (setq jump-pos (nth 1 symbol-ret))
                      (ac-php-location-stack-push)
                      (ac-php-goto-location jump-pos)
                      ;; (ac-php-location-stack-push)
                      )
                  (ac-php--goto-local-var-def local-var)))
            (cond
             ((member type '("class_member" "user_function" "named_argument"))
              (let ((file-pos (nth 1 symbol-ret)) tmp-arr)
                (setq tmp-arr (s-split ":" file-pos))
                (ac-php--debug "tmp-arr %S" tmp-arr)
                (cond
                 ((s-matches-p "sys" (nth 0 tmp-arr))
                  (goto-char (1+ (point)))
                  (message "need install : composer require jetbrains/phpstorm-stubs "))
                 (t
                  (let ((file-list (ac-php-g--file-list tags-data)))
                    ;; from get index
                    (setq jump-pos
                          (concat
                           (aref file-list (string-to-number (nth 0 tmp-arr)))
                           ":" (nth 1 tmp-arr)))
                    (ac-php-location-stack-push)
                    (ac-php-goto-location jump-pos)
                    (when (string= type "named_argument")
                      (let ((parameter-pos
                             (ac-php--parameter-definition-position
                              (nth 4 symbol-ret))))
                        (when parameter-pos
                          (goto-char parameter-pos))))))))))))
      (when local-var-flag (ac-php--goto-local-var-def local-var)))))

(defun ac-php-gen-def ()
  "DOCSTRING."
  (interactive)
  (let ((tags-data (ac-php-get-tags-data))
        line-txt
        (cur-word (ac-php--get-cur-word)))
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position)))
    (if (string-match (concat "$" cur-word) line-txt)
        (let ((class-name "<...>"))
          (when (string-match (concat cur-word"[\t ]*=[^(]*[(;]") line-txt)
            ;; call function
            (let (key-str-list pos)
              (save-excursion
                (re-search-forward "[;]")
                (re-search-backward "[^ \t]" nil t)
                (setq pos (point)))

              (when pos (setq key-str-list (ac-php-get-class-at-point pos)))

              (if key-str-list ;; class-name
                  (setq class-name (ac-php-get-class-name-by-key-list tags-data key-str-list))
                (progn ;; function TODO
                  ))))

          (kill-new (concat "\n\t/**  @var " class-name " $" cur-word " */\n")))
      (kill-new (concat "\n * @property " cur-word " $" cur-word "\n")))))

(defun ac-php-location-stack-forward ()
  "DEFUN."
  (interactive)
  (ac-php-location-stack-jump -1))

(defun ac-php-location-stack-back ()
  "DEFUN."
  (interactive)
  (ac-php-location-stack-jump 1))

(defun ac-php-location-stack-jump (by)
  "D BY."
  (let ((instack (nth ac-php-location-stack-index ac-php-location-stack))
        (cur (ac-php-current-location)))
    (if (not (string= instack cur))
        (ac-php-goto-location instack)
      (let ((target (+ ac-php-location-stack-index by)))
        (when (and (>= target 0) (< target (length ac-php-location-stack)))
          (setq ac-php-location-stack-index target)
          (ac-php-goto-location (nth ac-php-location-stack-index ac-php-location-stack)))))))

(defun ac-php--get-array-string(arr arr-len index)
  "Doc ARR-LEN ARR INDEX."
  (let (v)
    (if (< index arr-len)
        (progn
          (setq v (aref arr index))
          (if v v ""))
      "")))

(defun ac-php--phpdoc-content (start end)
  "Return normalized PHPDoc text between START and END.
Leading comment stars are removed, while line breaks are retained so tags can
be distinguished from their continuation lines."
  (let ((text (buffer-substring-no-properties start end))
        lines)
    (setq text (replace-regexp-in-string
                "\\`[ \t]*/\\*\\*+" "" text))
    (setq text (replace-regexp-in-string
                "\\*/[ \t\n\r]*\\'" "" text))
    (dolist (line (split-string text "\n"))
      (push (replace-regexp-in-string
             "^[ \t]*\\*[ \t]?" "" line)
            lines))
    (mapconcat #'identity (nreverse lines) "\n")))

(defun ac-php--phpdoc-tag-values (content tag)
  "Return all values for TAG in normalized PHPDoc CONTENT.
A value includes continuation lines up to the next PHPDoc tag."
  (let ((tag-pattern
         (concat "^[ \t]*@" (regexp-quote tag) "[ \t]+\\(.*\\)$"))
        current values)
    (dolist (line (split-string content "\n"))
      (cond
       ((string-match tag-pattern line)
        (when current
          (push (s-trim (mapconcat #'identity (nreverse current) " "))
                values))
        (setq current (list (match-string 1 line))))
       ((string-match-p "^[ \t]*@[[:alpha:]_-]+\\b" line)
        (when current
          (push (s-trim (mapconcat #'identity (nreverse current) " "))
                values)
          (setq current nil)))
       (current
        (push (s-trim line) current))))
    (when current
      (push (s-trim (mapconcat #'identity (nreverse current) " "))
            values))
    (nreverse values)))

(defun ac-php--phpdoc-tag-values-in-buffer (tag)
  "Return all values for PHPDoc TAG in the current buffer."
  (save-match-data
    (save-excursion
      (goto-char (point-min))
      (let (values)
        (while (re-search-forward "/\\*\\*" nil t)
          (let ((start (match-beginning 0)))
            (when (search-forward "*/" nil t)
              (let ((end (point)))
                (when (nth 4 (syntax-ppss (min (1- end) (+ start 3))))
                  (setq values
                        (append
                         values
                         (ac-php--phpdoc-tag-values
                          (ac-php--phpdoc-content start end) tag))))))))
        values))))

(defun ac-php--phpstan-type-aliases ()
  "Return PHPStan type aliases declared in PHPDoc comments in this buffer.
Each result is a cons cell whose car is the alias and whose cdr is its complete
possibly multiline type expression.  Later declarations replace earlier ones."
  (let ((aliases (make-hash-table :test #'equal)) results)
    (dolist (value (ac-php--phpdoc-tag-values-in-buffer "phpstan-type"))
      (when (string-match
             "\\`\\([[:alpha:]_][[:alnum:]_]*\\)[ \t]+\\(.+\\)\\'"
             value)
        (puthash (match-string 1 value)
                 (s-trim (match-string 2 value)) aliases)))
    (maphash (lambda (name type) (push (cons name type) results)) aliases)
    results))

(defun ac-php--split-top-level-type (text delimiter)
  "Split TEXT on top-level DELIMITER characters.
Delimiters inside quotes or (), [], {}, and <> are ignored."
  (let ((index 0) (start 0) (length (length text))
        (round 0) (square 0) (curly 0) (angle 0)
        quote escaped parts)
    (while (< index length)
      (let ((character (aref text index)))
        (cond
         (quote
          (cond
           (escaped (setq escaped nil))
           ((eq character ?\\) (setq escaped t))
           ((eq character quote) (setq quote nil))))
         ((memq character '(?\' ?\")) (setq quote character))
         ((eq character ?\() (setq round (1+ round)))
         ((eq character ?\)) (setq round (max 0 (1- round))))
         ((eq character ?\[) (setq square (1+ square)))
         ((eq character ?\]) (setq square (max 0 (1- square))))
         ((eq character ?\{) (setq curly (1+ curly)))
         ((eq character ?\}) (setq curly (max 0 (1- curly))))
         ((eq character ?<) (setq angle (1+ angle)))
         ((eq character ?>) (setq angle (max 0 (1- angle))))
         ((and (eq character delimiter)
               (= round 0) (= square 0) (= curly 0) (= angle 0))
          (push (substring text start index) parts)
          (setq start (1+ index)))))
      (setq index (1+ index)))
    (nreverse (cons (substring text start) parts))))

(defun ac-php--top-level-colon (text)
  "Return the position of the first top-level colon in TEXT."
  (let ((index 0) (length (length text))
        (round 0) (square 0) (curly 0) (angle 0)
        quote escaped result)
    (while (and (< index length) (not result))
      (let ((character (aref text index)))
        (cond
         (quote
          (cond
           (escaped (setq escaped nil))
           ((eq character ?\\) (setq escaped t))
           ((eq character quote) (setq quote nil))))
         ((memq character '(?\' ?\")) (setq quote character))
         ((eq character ?\() (setq round (1+ round)))
         ((eq character ?\)) (setq round (max 0 (1- round))))
         ((eq character ?\[) (setq square (1+ square)))
         ((eq character ?\]) (setq square (max 0 (1- square))))
         ((eq character ?\{) (setq curly (1+ curly)))
         ((eq character ?\}) (setq curly (max 0 (1- curly))))
         ((eq character ?<) (setq angle (1+ angle)))
         ((eq character ?>) (setq angle (max 0 (1- angle))))
         ((and (eq character ?:)
               (= round 0) (= square 0) (= curly 0) (= angle 0))
          (setq result index))))
      (setq index (1+ index)))
    result))

(defun ac-php--array-shapes-from-type (type aliases &optional seen)
  "Resolve every array-shape alternative in TYPE using ALIASES.
SEEN prevents recursive aliases from looping."
  (when (stringp type)
    (let (shapes)
      (dolist (alternative (ac-php--split-top-level-type type ?|))
        (let ((unwrapped
               (replace-regexp-in-string
                "\\`[?]\\|[ \t]*[?]\\'" "" (s-trim alternative))))
          (cond
           ((string-match-p "\\`array[ \t\n\r]*{" unwrapped)
            (push unwrapped shapes))
           ((and (not (member unwrapped seen))
                 (assoc unwrapped aliases))
            (setq shapes
                  (append
                   (nreverse
                    (ac-php--array-shapes-from-type
                     (cdr (assoc unwrapped aliases)) aliases
                     (cons unwrapped seen)))
                   shapes))))))
      (nreverse shapes))))

(defun ac-php--array-shape-from-type (type aliases &optional seen)
  "Resolve the first array-shape alternative in TYPE using ALIASES."
  (car (ac-php--array-shapes-from-type type aliases seen)))

(defun ac-php--array-element-type (type aliases &optional seen)
  "Return the element type of array-like TYPE using ALIASES.
SEEN prevents recursive aliases from looping."
  (when (stringp type)
    (let (elements)
      (dolist (alternative (ac-php--split-top-level-type type ?|))
        (let* ((unwrapped
                (replace-regexp-in-string
                 "\\`[?]\\|[ \t]*[?]\\'" "" (s-trim alternative)))
               element)
          (cond
           ((and (not (member unwrapped seen))
                 (assoc unwrapped aliases))
            (setq element
                  (ac-php--array-element-type
                   (cdr (assoc unwrapped aliases)) aliases
                   (cons unwrapped seen))))
           ((string-match
             "\\`\\(?:non-empty-\\)?list[ \t\n\r]*<\\(.+\\)>\\'"
             unwrapped)
            (setq element (s-trim (match-string 1 unwrapped))))
           ((string-match "\\`array[ \t\n\r]*<\\(.+\\)>\\'" unwrapped)
            (let ((arguments
                   (ac-php--split-top-level-type
                    (match-string 1 unwrapped) ?,)))
              (setq element
                    (s-trim (or (nth 1 arguments) (car arguments))))))
           ((string-match "\\`\\(.+\\)\\[\\]\\'" unwrapped)
            (setq element (s-trim (match-string 1 unwrapped)))))
          (when (and element (not (string= element "")))
            (dolist (part (ac-php--split-top-level-type element ?|))
              (let ((part (s-trim part)))
                (unless (or (string= part "") (member part elements))
                  (push part elements)))))))
      (when elements
        (mapconcat #'identity (nreverse elements) "|")))))

(defun ac-php--array-offset-component (offset)
  "Return the path component represented by array OFFSET, or nil.
String keys are returned as strings.  Integer indexes are tagged so callers
can distinguish them from quoted numeric keys."
  (cond
   ((string-match "\\`['\"]\\(.*\\)['\"]\\'" offset)
    (match-string 1 offset))
   ((string-match-p "\\`-?[0-9]+\\'" offset)
    (cons :index offset))))

(defun ac-php--variable-offset-expression (text)
  "Parse a simple variable offset expression from TEXT.
Return a plist containing `:variable' and `:path', or nil."
  (save-match-data
    (when (string-match
           "\\`[ \t\n\r]*\\$\\([[:alpha:]_][[:alnum:]_]*\\)" text)
      (let ((variable (match-string 1 text))
            (index (match-end 0))
            (length (length text))
            path)
        (catch 'invalid
          (while (< index length)
            (while (and (< index length)
                        (memq (aref text index) '(?\s ?\t ?\n ?\r)))
              (setq index (1+ index)))
            (when (< index length)
              (if (and (eq (aref text index) ??)
                       (< (1+ index) length)
                       (eq (aref text (1+ index)) ??))
                  (setq index length)
                (unless (eq (aref text index) ?\[)
                  (throw 'invalid nil))
                (let ((cursor (1+ index)) quote escaped close)
                  (while (and (< cursor length) (not close))
                    (let ((character (aref text cursor)))
                      (cond
                       (quote
                        (cond
                         (escaped (setq escaped nil))
                         ((eq character ?\\) (setq escaped t))
                         ((eq character quote) (setq quote nil))))
                       ((memq character '(?\' ?\")) (setq quote character))
                       ((eq character ?\]) (setq close cursor))))
                    (setq cursor (1+ cursor)))
                  (unless close (throw 'invalid nil))
                  (let* ((offset
                          (s-trim (substring text (1+ index) close)))
                         (component
                          (ac-php--array-offset-component offset)))
                    (unless component (throw 'invalid nil))
                    (push component path))
                  (setq index (1+ close))))))
          (list :variable variable :path (nreverse path)))))))

(defun ac-php--array-type-at-path (type path aliases)
  "Return the nested type reached from TYPE by array offset PATH."
  (let ((current-type type))
    (dolist (component path)
      (let* ((index-p (and (consp component) (eq (car component) :index)))
             (key (if index-p (cdr component) component))
             (shapes
              (and current-type
                   (ac-php--array-shapes-from-type current-type aliases)))
             (field (assoc key (ac-php--array-shapes-fields shapes))))
        (setq current-type
              (if field
                  (cdr field)
                (and index-p
                     (ac-php--array-element-type current-type aliases))))))
    current-type))

(defun ac-php--array-shape-fields (shape)
  "Return the keyed fields declared by array SHAPE.
Each field is represented by a cons cell (KEY . TYPE)."
  (when (and shape (string-match "{" shape))
    (let* ((open (match-beginning 0))
           (close (1- (length shape)))
           fields)
      (while (and (> close open) (not (eq (aref shape close) ?})))
        (setq close (1- close)))
      (when (> close open)
        (dolist (entry
                 (ac-php--split-top-level-type
                  (substring shape (1+ open) close) ?,))
          (let* ((entry (s-trim entry))
                 (colon (ac-php--top-level-colon entry)))
            (when colon
              (let* ((raw-key (s-trim (substring entry 0 colon)))
                     (type (s-trim (substring entry (1+ colon))))
                     (raw-key
                      (replace-regexp-in-string "[?][ \t]*\\'" "" raw-key))
                     key)
                (cond
                 ((string-match "\\`['\"]\\(.*\\)['\"]\\'" raw-key)
                  (setq key (match-string 1 raw-key)))
                 ((string-match-p
                   "\\`\\(?:[[:alpha:]_][[:alnum:]_]*\\|[0-9]+\\)\\'" raw-key)
                  (setq key raw-key)))
                (when (and key (not (string= type "")))
                  (push (cons key type) fields)))))))
      (nreverse fields))))

(defun ac-php--array-shapes-fields (shapes)
  "Return merged fields from array SHAPES, preserving declaration order."
  (let (fields)
    (dolist (shape shapes)
      (dolist (field (ac-php--array-shape-fields shape))
        (let ((existing (assoc (car field) fields)))
          (if existing
              (unless (member (cdr field)
                              (ac-php--split-top-level-type (cdr existing) ?|))
                (setcdr existing (concat (cdr existing) "|" (cdr field))))
            (setq fields (append fields (list field)))))))
    fields))

(defun ac-php--array-literal-key-position-p (open string-start)
  "Return non-nil when STRING-START begins a key slot in array OPEN."
  (save-excursion
    (goto-char (1+ open))
    (let ((depth (car (syntax-ppss (point))))
          (field-start (point)))
      (while (search-forward "," string-start t)
        (let* ((comma (1- (point)))
               (state (save-excursion (syntax-ppss comma))))
          (when (and (= (car state) depth)
                     (not (nth 3 state)) (not (nth 4 state)))
            (setq field-start (point)))))
      (string=
       (s-trim (ac-php--code-without-comments field-start string-start))
       ""))))

(defun ac-php--array-literal-used-keys (open current-string-start)
  "Return keys already declared in array OPEN.
CURRENT-STRING-START is excluded so an existing key can still be edited."
  (save-match-data
    (save-excursion
      (let* ((content-start (1+ open))
             (depth (car (syntax-ppss content-start)))
             (close (condition-case nil (scan-sexps open 1)
                      (scan-error nil)))
             (end (if close (1- close) current-string-start))
             (pattern
              (concat
               "\\(?:['\"]\\([^'\"]+\\)['\"]\\|"
               "\\([[:alpha:]_][[:alnum:]_]*\\|[0-9]+\\)\\)"
               "[ \t\n\r]*=>"))
             keys)
        (goto-char content-start)
        (while (re-search-forward pattern end t)
          (let* ((key-start (match-beginning 0))
                 (state (save-excursion (syntax-ppss key-start)))
                 (key (or (match-string-no-properties 1)
                          (match-string-no-properties 2))))
            (when (and key
                       (/= key-start current-string-start)
                       (= (car state) depth)
                       (not (nth 3 state)) (not (nth 4 state)))
              (push key keys))))
        (delete-dups (nreverse keys))))))

(defun ac-php--array-key-context (&optional pos)
  "Return the array-shape key completion context at POS.
The result describes either a variable offset or an array literal used as a
call argument, together with the prefix between the current quote and point."
  (save-match-data
    (save-excursion
      (goto-char (or pos (point)))
      (let* ((target (point))
             (state (syntax-ppss target))
             (string-start (and (nth 3 state) (nth 8 state))))
        (when string-start
          (let ((prefix (buffer-substring-no-properties
                         (1+ string-start) target))
                (active-open (nth 1 (syntax-ppss string-start))))
            (when (and active-open (eq (char-after active-open) ?\[))
              (let (path done variable-context)
                (goto-char active-open)
                (while (not done)
                  (skip-chars-backward " \t\n\r")
                  (if (eq (char-before) ?\])
                      (let* ((end (point))
                             (open (condition-case nil (scan-sexps end -1)
                                     (scan-error nil))))
                        (if (not open)
                            (setq done t)
                          (let ((offset
                                 (s-trim
                                  (buffer-substring-no-properties
                                   (1+ open) (1- end))))
                                component)
                            (setq component
                                  (ac-php--array-offset-component offset))
                            (if component
                                (progn
                                  (push component path)
                                  (goto-char open))
                              (setq done t)))))
                    (setq done t)))
                (skip-chars-backward " \t\n\r")
                (let ((end (point)))
                  (skip-chars-backward "a-zA-Z0-9_")
                  (when (eq (char-before) ?$)
                    (backward-char)
                    (setq variable-context
                          (list :variable
                                (substring
                                (buffer-substring-no-properties
                                  (point) end) 1)
                                :path path :prefix prefix
                                :open active-open))))
                (or variable-context
                    (and
                     (ac-php--array-literal-key-position-p
                      active-open string-start)
                    (let* ((call-open (nth 1 (syntax-ppss active-open)))
                           (callable
                            (and call-open
                                 (eq (char-after call-open) ?\()
                                 (ac-php--callable-name-before-open call-open))))
                      (when callable
                        (list :callable callable
                              :argument-index
                              (1- (length
                                   (ac-php--argument-ranges
                                    (1+ call-open) active-open)))
                              :used-keys
                              (ac-php--array-literal-used-keys
                               active-open string-start)
                              :prefix prefix :open active-open
                              :call-open call-open)))))))))))))

(defun ac-php--variable-assignment (variable pos)
  "Return VARIABLE's nearest simple assignment preceding POS.
The result records both the right-hand-side text and its buffer start."
  (save-match-data
    (save-excursion
      (goto-char pos)
      (let ((bound (save-excursion
                     (if (ac-php--beginning-of-defun)
                         (point)
                       (point-min))))
            (pattern
             (concat "\\$" (regexp-quote variable) "[ \t\n\r]*="))
            result)
        (while (and (not result) (re-search-backward pattern bound t))
          (let ((assignment-start (match-beginning 0))
                (value-start (match-end 0)))
            (when (and (not (ac-php--in-string-or-comment-p assignment-start))
                       (not (eq (char-after value-start) ?=))
                       (not (memq (char-before assignment-start)
                                  '(?+ ?- ?* ?/ ?% ?. ??))))
              (goto-char value-start)
              (let ((depth (car (syntax-ppss value-start))) end)
                (while (and (not end) (search-forward ";" pos t))
                  (let ((semicolon (1- (point))))
                    (when (and (= (car (syntax-ppss semicolon)) depth)
                               (not (ac-php--in-string-or-comment-p semicolon)))
                      (setq end semicolon))))
                (when end
                  (setq result
                        (list :text
                              (s-trim
                               (ac-php--code-without-comments value-start end))
                              :start value-start :end end))))
              (unless result
                (goto-char assignment-start)))))
        result))))

(defun ac-php--phpdoc-before-line (pos)
  "Return normalized PHPDoc immediately preceding the line at POS."
  (save-excursion
    (goto-char pos)
    (beginning-of-line)
    (skip-chars-backward " \t\n\r")
    (when (and (>= (- (point) (point-min)) 2)
               (string= (buffer-substring-no-properties (- (point) 2) (point))
                        "*/"))
      (let ((end (point)))
        (when (search-backward "/**" nil t)
          (ac-php--phpdoc-content (point) end))))))

(defun ac-php--phpdoc-parameter-types (content)
  "Return (PARAMETER . TYPE) pairs from normalized PHPDoc CONTENT."
  (let (parameters)
    (dolist (value (ac-php--phpdoc-tag-values content "param"))
      (when (string-match
             "\\$\\([[:alpha:]_][[:alnum:]_]*\\)\\b" value)
        (let ((name (match-string 1 value))
              (type (s-trim (substring value 0 (match-beginning 0)))))
          (when (not (string= type ""))
            (push (cons name type) parameters)))))
    (nreverse parameters)))

(defun ac-php--matching-parenthesis-in-string (text open)
  "Return the closing parenthesis in TEXT matching OPEN, or nil."
  (let ((index (1+ open)) (depth 1) (length (length text))
        quote escaped result)
    (while (and (< index length) (not result))
      (let ((character (aref text index)))
        (cond
         (quote
          (cond
           (escaped (setq escaped nil))
           ((eq character ?\\) (setq escaped t))
           ((eq character quote) (setq quote nil))))
         ((memq character '(?\' ?\")) (setq quote character))
         ((eq character ?\() (setq depth (1+ depth)))
         ((eq character ?\))
          (setq depth (1- depth))
          (when (= depth 0)
            (setq result index)))))
      (setq index (1+ index)))
    result))

(defun ac-php--matching-angle-bracket-in-string (text open)
  "Return the closing angle bracket in TEXT matching OPEN, or nil."
  (let ((index (1+ open)) (depth 1) (length (length text))
        quote escaped result)
    (while (and (< index length) (not result))
      (let ((character (aref text index)))
        (cond
         (quote
          (cond
           (escaped (setq escaped nil))
           ((eq character ?\\) (setq escaped t))
           ((eq character quote) (setq quote nil))))
         ((memq character '(?\' ?\")) (setq quote character))
         ((eq character ?<) (setq depth (1+ depth)))
         ((eq character ?>)
          (setq depth (1- depth))
          (when (= depth 0)
            (setq result index)))))
      (setq index (1+ index)))
    result))

(defun ac-php--phpdoc-template-bounds (declarations)
  "Return (TEMPLATE . BOUND) pairs from method template DECLARATIONS."
  (let (bounds)
    (when declarations
      (dolist (declaration
               (ac-php--split-top-level-type declarations ?,))
        (let ((declaration (s-trim declaration)))
          (when (string-match
                 (concat
                  "\\`\\([[:alpha:]_][[:alnum:]_]*\\)"
                  "[ \t\n\r]+\\(?:of\\|as\\)[ \t\n\r]+\\(.+\\)\\'")
                 declaration)
            (push (cons (match-string 1 declaration)
                        (s-trim (match-string 2 declaration)))
                  bounds)))))
    (nreverse bounds)))

(defun ac-php--phpdoc-method-info-from-value (value name index)
  "Return parameter INDEX information for @method VALUE named NAME.
The result contains the parameter type and any inline method template bounds."
  (let ((pattern (concat "\\_<" (regexp-quote name) "\\_>"))
        (scan 0))
    (catch 'info
      (while (string-match pattern value scan)
        (let ((cursor (match-end 0)) templates)
          (setq scan cursor)
          (while (and (< cursor (length value))
                      (memq (aref value cursor) '(?\s ?\t ?\n ?\r)))
            (setq cursor (1+ cursor)))
          (when (and (< cursor (length value))
                     (eq (aref value cursor) ?<))
            (let ((close
                   (ac-php--matching-angle-bracket-in-string value cursor)))
              (when close
                (setq templates (substring value (1+ cursor) close)
                      cursor (1+ close))
                (while (and (< cursor (length value))
                            (memq (aref value cursor) '(?\s ?\t ?\n ?\r)))
                  (setq cursor (1+ cursor))))))
          (when (and (< cursor (length value))
                     (eq (aref value cursor) ?\())
            (let ((close
                   (ac-php--matching-parenthesis-in-string value cursor)))
              (when close
                (let* ((parameter
                        (nth index
                             (ac-php--split-top-level-type
                              (substring value (1+ cursor) close) ?,)))
                       (type
                        (ac-php--parameter-type-from-declaration parameter)))
                  (when parameter
                    (throw 'info
                           (list :type type
                                 :templates
                                 (ac-php--phpdoc-template-bounds templates))))))))))
      nil)))

(defun ac-php--parameter-type-from-declaration (declaration)
  "Return the type preceding the parameter variable in DECLARATION."
  (when (and declaration
             (string-match
              "\\$[[:alpha:]_][[:alnum:]_]*\\b" declaration))
    (let ((type (s-trim (substring declaration 0 (match-beginning 0)))))
      (setq type
            (replace-regexp-in-string
             "[ \t]*\\(?:&\\|[.][.][.]\\)[ \t]*\\'" "" type))
      (unless (string= type "") type))))

(defun ac-php--phpdoc-method-parameter-info (name index)
  "Return @method NAME's parameter information at INDEX in this buffer."
  (catch 'info
    (dolist (value (ac-php--phpdoc-tag-values-in-buffer "method"))
      (let ((info
             (ac-php--phpdoc-method-info-from-value value name index)))
        (when info (throw 'info info))))
    nil))

(defun ac-php--phpdoc-method-parameter-type (name index)
  "Return @method NAME's parameter type at zero-based INDEX in this buffer."
  (plist-get (ac-php--phpdoc-method-parameter-info name index) :type))

(defun ac-php--local-callable-declaration (name pos)
  "Return the declaration position of local callable NAME near POS."
  (save-match-data
    (save-excursion
      (goto-char pos)
      (let ((pattern
             (concat "\\_<function\\_>[ \t\n\r]+&?[ \t\n\r]*"
                     (regexp-quote name) "[ \t\n\r]*("))
            declaration)
        (while (and (not declaration) (re-search-backward pattern nil t))
          (unless (ac-php--in-string-or-comment-p (match-beginning 0))
            (setq declaration (match-beginning 0))))
        (unless declaration
          (goto-char pos)
          (while (and (not declaration) (re-search-forward pattern nil t))
            (unless (ac-php--in-string-or-comment-p (match-beginning 0))
              (setq declaration (match-beginning 0)))))
        declaration))))

(defun ac-php--callable-name-before-open (open)
  "Return the callable identifier immediately before parenthesis OPEN."
  (save-excursion
    (goto-char open)
    (forward-comment (- (buffer-size)))
    (let ((end (point)))
      (skip-chars-backward "a-zA-Z0-9_\\")
      (when (and (< (point) end)
                 (not (eq (char-before) ?$)))
        (buffer-substring-no-properties (point) end)))))

(defun ac-php--local-declaration-parameter-names (declaration)
  "Return parameter names in source order for DECLARATION."
  (save-match-data
    (save-excursion
      (goto-char declaration)
      (when (re-search-forward "(" nil t)
        (let* ((open (1- (point)))
               (close (condition-case nil (scan-sexps open 1)
                        (scan-error nil)))
               parameters)
          (when close
            (dolist (range
                     (ac-php--argument-ranges (1+ open) (1- close)))
              (goto-char (car range))
              (if (re-search-forward
                   "\\$\\([[:alpha:]_][[:alnum:]_]*\\)" (cdr range) t)
                  (push (match-string-no-properties 1) parameters)
                (push nil parameters)))
            (nreverse parameters)))))))

(defun ac-php--phpdoc-parameter-type-at-point (variable pos)
  "Return the PHPDoc type of VARIABLE in the function containing POS."
  (save-excursion
    (goto-char pos)
    (when (ac-php--beginning-of-defun)
      (cdr (assoc variable
                  (ac-php--phpdoc-parameter-types
                   (or (ac-php--phpdoc-before-line (point)) "")))))))

(defun ac-php--phpdoc-variable-type-from-value (value variable)
  "Return VARIABLE's type from a PHPDoc @var VALUE, or nil."
  (when (string-match
         (concat "\\$" (regexp-quote variable) "\\b") value)
    (let ((type (s-trim (substring value 0 (match-beginning 0)))))
      (unless (string= type "") type))))

(defun ac-php--phpdoc-variable-type-at-point (variable pos)
  "Return VARIABLE's nearest PHPDoc @var type visible at POS."
  (save-match-data
    (save-excursion
      (goto-char pos)
      (let* ((in-function-p (ac-php--in-function-p pos))
             (bound
              (if in-function-p
                  (save-excursion
                    (goto-char pos)
                    (ac-php--beginning-of-defun)
                    (line-beginning-position))
                (point-min))))
        (catch 'type
          (while (re-search-backward "/\\*\\*" bound t)
            (let ((start (point)))
              (when (or in-function-p
                        (not (ac-php--in-function-p start)))
                (save-excursion
                  (when (search-forward "*/" pos t)
                    (let ((end (point)))
                      (when (nth 4 (syntax-ppss
                                    (min (1- end) (+ start 3))))
                        (dolist
                            (value
                             (ac-php--phpdoc-tag-values
                              (ac-php--phpdoc-content start end) "var"))
                          (let ((type
                                 (ac-php--phpdoc-variable-type-from-value
                                  value variable)))
                            (when type (throw 'type type)))))))))))
          nil)))))

(defun ac-php--local-callable-parameter-type (name index pos)
  "Return local callable NAME's PHPDoc parameter type at zero-based INDEX."
  (let ((declaration (ac-php--local-callable-declaration name pos)))
    (when declaration
      (let* ((parameter-name
              (nth index
                   (ac-php--local-declaration-parameter-names declaration)))
             (parameters
              (ac-php--phpdoc-parameter-types
               (or (ac-php--phpdoc-before-line declaration) ""))))
        (cdr (assoc parameter-name parameters))))))

(defun ac-php--tag-source-file (tags-data tag)
  "Return TAG's source filename from TAGS-DATA, or nil."
  (when (and tag (> (length tag) 3))
    (let ((location (aref tag 3))
          (file-list (ac-php-g--file-list tags-data)))
      (when (and (stringp location)
                 (string-match "\\`\\([0-9]+\\):" location))
        (let ((index (string-to-number (match-string 1 location))))
          (when (< index (length file-list))
            (let ((file (aref file-list index)))
              (if (file-name-absolute-p file)
                  file
                (expand-file-name file (ac-php-g--project-root-dir tags-data))))))))))

(defun ac-php--phpdoc-method-parameter-type-in-file (file name index)
  "Return @method NAME's parameter type at INDEX from FILE."
  (plist-get
   (ac-php--phpdoc-method-parameter-info-in-file file name index) :type))

(defun ac-php--phpdoc-method-parameter-info-in-file (file name index)
  "Return @method NAME's parameter information at INDEX from FILE."
  (when (and file (file-readable-p file))
    (let ((buffer (get-file-buffer file)))
      (if buffer
          (with-current-buffer buffer
            (ac-php--phpdoc-method-parameter-info name index))
        (with-temp-buffer
          (insert-file-contents file)
          (php-mode)
          (ac-php--phpdoc-method-parameter-info name index))))))

(defun ac-php--tagged-callable-parameter-type (tags-data context)
  "Return CONTEXT's parameter type from indexed TAGS-DATA or its source."
  (when (and tags-data (plist-get context :call-open))
    (let* ((tag (ac-php--callable-tag
                 tags-data (plist-get context :call-open)))
           (index (plist-get context :argument-index))
           (typed-parameter
            (and tag (> (length tag) 8)
                 (nth index (ac-php--signature-parameters (aref tag 8)))))
           (parameter
            (and tag (> (length tag) 2)
                 (nth index (ac-php--signature-parameters (aref tag 2)))))
           (type
            (ac-php--parameter-type-from-declaration
             (cdr (or typed-parameter parameter)))))
      (or type
          (and tag
               (ac-php--phpdoc-method-parameter-type-in-file
                (ac-php--tag-source-file tags-data tag)
                (plist-get context :callable) index))))))

(defun ac-php--local-callable-return-type (name pos)
  "Return the PHPDoc return type of local callable NAME visible at POS."
  (let ((declaration (ac-php--local-callable-declaration name pos)))
    (when declaration
      (car (ac-php--phpdoc-tag-values
            (or (ac-php--phpdoc-before-line declaration) "")
            "return")))))

(defun ac-php--assignment-return-type (assignment tags-data)
  "Infer the callable return type represented by ASSIGNMENT using TAGS-DATA."
  (let ((text (plist-get assignment :text))
        (start (plist-get assignment :start))
        (scan 0) callable callable-end)
    (while (string-match
            "\\([[:alpha:]_][[:alnum:]_]*\\)[ \t\n\r]*(" text scan)
      (setq callable (match-string 1 text)
            callable-end (match-end 1)
            scan (match-end 0)))
    (when callable
      (or (ac-php--local-callable-return-type callable start)
          (when tags-data
            (save-excursion
              (goto-char (+ start callable-end))
              (nth 2 (ac-php-find-symbol-at-point-pri tags-data))))))))

(defun ac-php--array-expression-type
    (expression pos tags-data aliases seen)
  "Infer the type of variable offset EXPRESSION visible at POS."
  (let ((reference (ac-php--variable-offset-expression expression)))
    (when reference
      (let* ((variable (plist-get reference :variable))
             (type
              (ac-php--array-variable-type
               variable pos tags-data seen aliases)))
        (ac-php--array-type-at-path
         type (plist-get reference :path) aliases)))))

(defun ac-php--foreach-variable-type
    (variable pos tags-data aliases seen)
  "Infer VARIABLE's element type from an enclosing foreach at POS."
  (save-match-data
    (save-excursion
      (goto-char pos)
      (let ((bound
             (save-excursion
               (if (ac-php--beginning-of-defun)
                   (point)
                 (point-min))))
            result)
        (while (and (not result)
                    (re-search-backward
                     "\\_<foreach\\_>[ \t\n\r]*(" bound t))
          (let* ((foreach-start (match-beginning 0))
                 (open (1- (match-end 0)))
                 (close (condition-case nil (scan-sexps open 1)
                          (scan-error nil))))
            (when (and close
                       (not (ac-php--in-string-or-comment-p foreach-start)))
              (goto-char close)
              (forward-comment (buffer-size))
              (let* ((body-open (point))
                     (body-close
                      (and (eq (char-after body-open) ?{)
                           (condition-case nil (scan-sexps body-open 1)
                             (scan-error nil))))
                     (contains-pos-p
                      (and (eq (char-after body-open) ?{)
                           (> pos body-open)
                           (or (not body-close) (< pos body-close)))))
                (when contains-pos-p
                  (let* ((header
                          (ac-php--code-without-comments
                           (1+ open) (1- close)))
                         (as-pattern "[ \t\n\r]+as[ \t\n\r]+"))
                    (when (string-match as-pattern header)
                      (let ((iterable
                             (s-trim
                              (substring header 0 (match-beginning 0))))
                            (binding (substring header (match-end 0)))
                            (scan 0) last-variable)
                        (while (string-match
                                "\\$\\([[:alpha:]_][[:alnum:]_]*\\)"
                                binding scan)
                          (setq last-variable (match-string 1 binding)
                                scan (match-end 0)))
                        (when (string= variable last-variable)
                          (setq result
                                (ac-php--array-element-type
                                 (ac-php--array-expression-type
                                  iterable foreach-start tags-data
                                  aliases seen)
                                 aliases)))))))))
            (goto-char foreach-start)))
        result))))

(defun ac-php--array-variable-type
    (variable pos tags-data &optional seen aliases)
  "Infer VARIABLE's PHPDoc type at POS using TAGS-DATA when necessary."
  (unless (member variable seen)
    (let ((seen (cons variable seen))
          (aliases (or aliases (ac-php--phpstan-type-aliases))))
      (or (ac-php--phpdoc-variable-type-at-point variable pos)
          (ac-php--phpdoc-parameter-type-at-point variable pos)
          (ac-php--foreach-variable-type
           variable pos tags-data aliases seen)
          (let ((assignment (ac-php--variable-assignment variable pos)))
            (and assignment
                 (or
                  (ac-php--array-expression-type
                   (plist-get assignment :text)
                   (plist-get assignment :start)
                   tags-data aliases seen)
                  (ac-php--assignment-return-type assignment tags-data))))))))

(defun ac-php-candidate-array-key (tags-data &optional context)
  "Return array-shape key candidates at point using TAGS-DATA.
CONTEXT may be supplied from `ac-php--array-key-context'."
  (let* ((context (or context (ac-php--array-key-context)))
         (aliases (and context (ac-php--phpstan-type-aliases)))
         (type
          (and context
               (if (plist-get context :variable)
                   (ac-php--array-variable-type
                    (plist-get context :variable) (point) tags-data)
                 (or
                  (ac-php--local-callable-parameter-type
                   (plist-get context :callable)
                   (plist-get context :argument-index) (point))
                  (ac-php--tagged-callable-parameter-type tags-data context)
                  (ac-php--phpdoc-method-parameter-type
                   (plist-get context :callable)
                   (plist-get context :argument-index))))))
         (current-type
          (ac-php--array-type-at-path
           type (plist-get context :path) aliases)))
    (let* ((shapes
            (and current-type
                 (ac-php--array-shapes-from-type current-type aliases)))
           (used-keys (plist-get context :used-keys))
           candidates)
      (dolist (field (ac-php--array-shapes-fields shapes))
        (unless (member (car field) used-keys)
          (push (propertize
                 (car field)
                 'ac-php-help (cdr field)
                 'ac-php-return-type (cdr field)
                 'ac-php-tag-type "a"
                 'summary (cdr field))
                candidates)))
      (nreverse candidates))))

(defun ac-php--argument-ranges (start end)
  "Split arguments between START and END at top-level commas.
Return a list of (START . END) buffer positions, preserving empty arguments."
  (save-excursion
    (goto-char start)
    (let ((depth (car (syntax-ppss start)))
          (argument-start start)
          ranges)
      (while (search-forward "," end t)
        (let* ((comma (1- (point)))
               (state (save-excursion (syntax-ppss comma))))
          (when (and (= (car state) depth)
                     (not (nth 3 state)) (not (nth 4 state)))
            (push (cons argument-start comma) ranges)
            (setq argument-start (1+ comma)))))
      (nreverse (cons (cons argument-start end) ranges)))))

(defun ac-php--string-literal-argument-context (&optional pos)
  "Return direct string argument completion context at POS, or nil."
  (save-match-data
    (save-excursion
      (goto-char (or pos (point)))
      (let* ((target (point))
             (state (syntax-ppss target))
             (string-start (and (nth 3 state) (nth 8 state))))
        (when string-start
          (let* ((call-open (nth 1 (syntax-ppss string-start)))
                 (callable
                  (and call-open
                       (eq (char-after call-open) ?\()
                       (ac-php--callable-name-before-open call-open)))
                 (ranges
                  (and callable
                       (ac-php--argument-ranges
                        (1+ call-open) string-start)))
                 (current (car (last ranges))))
            (when (and current
                       (string=
                        (s-trim
                         (ac-php--code-without-comments
                          (car current) string-start))
                        ""))
              (list :callable callable
                    :argument-index (1- (length ranges))
                    :prefix
                    (buffer-substring-no-properties
                     (1+ string-start) target)
                    :call-open call-open))))))))

(defun ac-php--string-literals-from-type (type)
  "Return string literal alternatives declared by PHPDoc TYPE."
  (let (literals)
    (when (stringp type)
      (dolist (alternative (ac-php--split-top-level-type type ?|))
        (let ((alternative (s-trim alternative)) value)
          (cond
           ((string-match "\\`'\\([^']*\\)'\\'" alternative)
            (setq value (match-string 1 alternative)))
           ((string-match "\\`\"\\([^\"]*\\)\"\\'" alternative)
            (setq value (match-string 1 alternative)))
           ((string-match
             "\\`string([ \t\n\r]*'\\([^']*\\)'[ \t\n\r]*)\\'"
             alternative)
            (setq value (match-string 1 alternative)))
           ((string-match
             "\\`string([ \t\n\r]*\"\\([^\"]*\\)\"[ \t\n\r]*)\\'"
             alternative)
            (setq value (match-string 1 alternative))))
          (when (and value (not (member value literals)))
            (push value literals)))))
    (nreverse literals)))

(defun ac-php--tagged-phpdoc-method-parameter-info (tags-data context)
  "Return source PHPDoc method information for indexed call CONTEXT."
  (when (and tags-data (plist-get context :call-open))
    (let ((tag (ac-php--callable-tag
                tags-data (plist-get context :call-open))))
      (and tag
           (ac-php--phpdoc-method-parameter-info-in-file
            (ac-php--tag-source-file tags-data tag)
            (plist-get context :callable)
            (plist-get context :argument-index))))))

(defun ac-php-candidate-string-literal (tags-data &optional context)
  "Return string literal argument candidates using TAGS-DATA.
CONTEXT may be supplied from `ac-php--string-literal-argument-context'."
  (let* ((context
          (or context (ac-php--string-literal-argument-context)))
         (name (plist-get context :callable))
         (index (plist-get context :argument-index))
         (local-type
          (and context
               (ac-php--local-callable-parameter-type
                name index (point))))
         (source-info
          (and context
               (or (ac-php--tagged-phpdoc-method-parameter-info
                    tags-data context)
                   (ac-php--phpdoc-method-parameter-info name index))))
         (type
          (and context
               (or local-type
                   (plist-get source-info :type)
                   (ac-php--tagged-callable-parameter-type
                    tags-data context))))
         (bound
          (and type
               (cdr (assoc type (plist-get source-info :templates)))))
         (literal-type (or bound type))
         candidates)
    (dolist (literal (ac-php--string-literals-from-type literal-type))
      (push (propertize
             literal
             'ac-php-help literal-type
             'ac-php-return-type type
             'ac-php-tag-type "v"
             'summary literal-type)
            candidates))
    (nreverse candidates)))

(defun ac-php--named-argument-context ()
  "Return the argument-name context at point, or nil.
Only the beginning of an argument in the innermost parenthesized expression
is eligible; argument values, strings, comments and arrays are excluded."
  (save-excursion
    (let* ((pos (point))
           (state (syntax-ppss pos))
           (open (nth 1 state)))
      (when (and open (eq (char-after open) ?\()
                 (not (nth 3 state)) (not (nth 4 state)))
        (let* ((end (or (condition-case nil
                           (let ((close (scan-sexps open 1)))
                             (and close (1- close)))
                         (scan-error nil))
                       pos))
               (ranges (ac-php--argument-ranges (1+ open) end))
               (current (cl-find-if
                         (lambda (range)
                           (<= (car range) pos (cdr range)))
                         ranges)))
          (when current
            (let ((prefix (s-trim (ac-php--code-without-comments
                                   (car current) pos))))
              (when (string-match-p
                     "\\`\\(?:[[:alpha:]_][[:alnum:]_]*\\)?\\'" prefix)
                (list :open open :current current :ranges ranges
                      :prefix prefix)))))))))

(defun ac-php--callable-tag (tags-data open)
  "Resolve the function, method or constructor called at OPEN in TAGS-DATA."
  (save-excursion
    (goto-char open)
    (forward-comment (- (buffer-size)))
    (let ((name-end (point)))
      (skip-chars-backward "a-zA-Z0-9_\\\\")
      (let* ((name-start (point))
             (name (buffer-substring-no-properties name-start name-end))
             (function-map (ac-php-g--function-map tags-data))
             (previous-word
              (save-excursion
                (forward-comment (- (buffer-size)))
                (when (eq (char-before) ?&)
                  (backward-char)
                  (forward-comment (- (buffer-size))))
                (let ((word-end (point)))
                  (skip-chars-backward "a-zA-Z_")
                  (downcase (buffer-substring-no-properties
                             (point) word-end)))))
             (constructor-p (string= previous-word "new")))
        (when (and (not (string= name ""))
                   (not (eq (char-before name-start) ?$))
                   (not (member previous-word '("function" "fn"))))
          (goto-char name-end)
          (let ((chain (unless constructor-p
                         (ac-php-get-class-at-point tags-data))))
            (if chain
                (let ((class-name
                       (ac-php-get-class-name-by-key-list
                        tags-data (replace-regexp-in-string
                                   "\\.[^.]*$" "" chain))))
                  (ac-php-get-class-member-info
                   (ac-php-g--class-map tags-data)
                   (ac-php-g--inherit-map tags-data)
                   class-name (concat name "(") tags-data))
              (let* ((class-name
                      (when constructor-p
                        (if (member (downcase name) '("self" "static" "parent"))
                            (ac-php-get-class-name-by-key-list
                             tags-data
                             (concat (ac-php-get-cur-full-class-name)
                                     (if (string= (downcase name) "parent")
                                         ".__parent__" "")))
                          (ac-php--get-class-full-name-in-cur-buffer
                           name function-map nil))))
                     (full-name
                      (ac-php--get-class-full-name-in-cur-buffer
                       (concat (or class-name name) "(") function-map nil)))
                (or (and full-name (gethash full-name function-map))
                    (and class-name
                         (ac-php-get-class-member-info
                          (ac-php-g--class-map tags-data)
                          (ac-php-g--inherit-map tags-data)
                          class-name "__construct(" tags-data)))))))))))

(defun ac-php--signature-parameters (signature)
  "Return (NAME . DECLARATION) pairs from a tagged PHP SIGNATURE."
  (when (and (stringp signature) (not (string= signature "")))
    (let ((table (syntax-table)))
      (with-temp-buffer
        (set-syntax-table table)
        (insert (ac-php-clean-document signature))
        (let (parameters)
          (dolist (range (ac-php--argument-ranges (point-min) (point-max)))
            (let ((declaration (s-trim (ac-php--code-without-comments
                                      (car range) (cdr range)))))
              (when (string-match
                     "\\$\\([[:alpha:]_][[:alnum:]_]*\\)" declaration)
                (push (cons (match-string 1 declaration) declaration)
                      parameters))))
          (nreverse parameters))))))

(defun ac-php--named-argument-symbol (tags-data)
  "Return symbol information for a named argument label at point in TAGS-DATA."
  (save-match-data
    (save-excursion
      (skip-chars-backward "a-zA-Z0-9_")
      (let ((start (point)))
        (skip-chars-forward "a-zA-Z0-9_")
        (let* ((end (point))
               (name (buffer-substring-no-properties start end))
               (context (ac-php--named-argument-context))
               (tag (and context tags-data (not (string= name ""))
                         (string= name (plist-get context :prefix))
                         (ac-php--callable-tag
                          tags-data (plist-get context :open)))))
          (forward-comment (buffer-size))
          (when (and tag (eq (char-after) ?:)
                     (not (eq (char-after (1+ (point))) ?:))
                     (assoc name (ac-php--signature-parameters (aref tag 2))))
            (list "named_argument" (aref tag 3) "" tag name)))))))

(defun ac-php--parameter-definition-position (name)
  "Find parameter NAME in the callable declared on the current indexed line.
Return its buffer position, or nil without moving point.  Only the signature
is searched, excluding attributes, comments, literals and default values."
  (save-match-data
    (save-excursion
      (let ((line-start (line-beginning-position))
            (line-end (line-end-position))
            open result)
        (goto-char line-end)
        (while (and (not open) (re-search-backward "\\_<function\\_>" nil t))
          (let ((function-pos (point))
                (function-end (match-end 0)))
            (unless (ac-php--in-string-or-comment-p function-pos)
              (save-excursion
                (goto-char function-end)
                (forward-comment (buffer-size))
                (when (eq (char-after) ?&)
                  (forward-char)
                  (forward-comment (buffer-size)))
                (when (looking-at "[[:alpha:]_][[:alnum:]_]*")
                  (let ((name-pos (point)))
                    (goto-char (match-end 0))
                    (forward-comment (buffer-size))
                    (when (and (eq (char-after) ?\()
                               (or (<= line-start function-pos line-end)
                                   (<= line-start name-pos line-end)))
                      (setq open (point)))))))))
        (when open
          (let ((close (condition-case nil (scan-sexps open 1)
                         (scan-error nil)))
                (depth (1+ (car (syntax-ppss open)))))
            (when close
              (dolist (range (ac-php--argument-ranges (1+ open) (1- close)))
                (goto-char (car range))
                (let (parameter-found)
                  (while (and (not parameter-found)
                              (re-search-forward
                               "\\$\\([[:alpha:]_][[:alnum:]_]*\\)" (cdr range) t))
                    (let* ((parameter-name (match-string-no-properties 1))
                           (parameter-pos (match-beginning 0))
                           (state (save-excursion (syntax-ppss parameter-pos))))
                      (when (and (= (car state) depth)
                                 (not (nth 3 state)) (not (nth 4 state)))
                        (setq parameter-found t)
                        (when (string= name parameter-name)
                          (setq result parameter-pos))))))))))
        result))))

(defun ac-php-candidate-named-argument (tags-data)
  "Return PHP named argument candidates at point using TAGS-DATA."
  (save-match-data
    (save-excursion
      (let* ((context (ac-php--named-argument-context))
             (tag (and context tags-data
                       (ac-php--callable-tag
                        tags-data (plist-get context :open)))))
        (when tag
          (let* ((parameters (ac-php--signature-parameters (aref tag 2)))
                 (current (plist-get context :current))
                 (prefix (plist-get context :prefix))
                 (colon-present-p
                  (save-excursion
                    (skip-chars-forward "a-zA-Z0-9_")
                    (forward-comment (buffer-size))
                    (and (eq (char-after) ?:)
                         (not (eq (char-after (1+ (point))) ?:)))))
                 (positional-count 0)
                 used candidates)
            (dolist (range (plist-get context :ranges))
              (unless (eq range current)
                (let ((argument (s-trim (ac-php--code-without-comments
                                        (car range) (cdr range)))))
                  (cond
                   ((string-match
                     (concat "\\`\\([[:alpha:]_][[:alnum:]_]*\\)"
                             "[ \t\n\r]*:\\(?:[^:]\\|\\'\\)") argument)
                    (push (match-string 1 argument) used))
                   ((and (< (car range) (car current))
                         (not (string= argument ""))
                         (not (string-prefix-p "..." argument)))
                    (setq positional-count (1+ positional-count)))))))
            (dolist (parameter (nthcdr positional-count parameters))
              (let ((name (car parameter)))
                (when (and (string-prefix-p prefix name)
                           (not (member name used)))
                  (push (propertize
                         (concat name (if colon-present-p "" ": "))
                         'ac-php-help (cdr parameter)
                         'ac-php-tag-type "v"
                         'ac-php-return-type ""
                         'summary "")
                        candidates))))
            (nreverse candidates)))))))

(defun ac-php-candidate ()
  "Doc."
  (let (key-str-list tags-data array-context literal-context extra-completion)
    (ac-php--debug "=== 1ac-php-candidate")
    (setq tags-data (ac-php-get-tags-data))
    (setq array-context (ac-php--array-key-context))
    (setq literal-context (ac-php--string-literal-argument-context))
    (setq extra-completion (ac-php-extra-completion-at-point tags-data))
    (cond
     ((and extra-completion
           (plist-member extra-completion :candidates))
      (plist-get extra-completion :candidates))
     (array-context
      (ac-php-candidate-array-key tags-data array-context))
     (literal-context
      (ac-php-candidate-string-literal tags-data literal-context))
     (t
      (setq key-str-list (ac-php-get-class-at-point tags-data))
      (ac-php--debug "GET key-str-list :%s" key-str-list)
      (append (ac-php-candidate-named-argument tags-data)
              (if key-str-list
                  (ac-php-candidate-class tags-data key-str-list)
                (ac-php-candidate-other tags-data)))))))

;; "Return a 'word' before current point.

;; The word 'word' means a combination of characters that forms a valid identifier
;; in PHP except the dollar sign.  Meant for `ac-php-find-symbol-at-point-pri'.

;; Examples:

;;   :-------------------------:--------------------:
;;   | If the point at the end | Will return        |
;;   :-------------------------:--------------------:
;;   | $someVariable           | someWariable       |
;;   | Acme\\Service\\Foo      | Acme\\Service\\Foo |
;;   | foo()->bar              | bar                |
;;   | foo()?->bar             | bar                |
;;   | foo()                   |                    |
;;   | 'some string'           |                    |
;;   :-------------------------:--------------------:

;; Return empty string if there is no valid sequence of characters.

;; Note: To conveniently describe in the documentation, double quotes (\") have
;; been replaced by '."

(defun ac-php--get-cur-word ()
  "Return a `word' before current point.

The word `word' means a combination of characters that forms a valid identifier
in PHP except the dollar sign.  Meant for `ac-php-find-symbol-at-point-pri'.

Examples:

Return empty string if there is no valid sequence of characters.

Note: To conveniently describe in the documentation, double quotes (\") have
been replaced by '."
  (let (start-pos)
    (save-excursion
      (skip-chars-backward "a-z0-9A-Z_\\\\")
      (setq start-pos (point))
      (skip-chars-forward "a-z0-9A-Z_\\\\")
      (buffer-substring-no-properties start-pos (point)))))


;; Return empty string if there is no valid sequence of characters."

(defun ac-php--get-cur-word-with-function-flag ()
  "Return a `function' name before current point.

The word `function' means a combination of characters that forms a valid
function name.  Meant for `ac-php-find-symbol-at-point-pri'.

Examples:

  :-------------------------:--------------------:
  | If the point at #       | Will return        |
  :-------------------------:--------------------:
  | function foo()#         |                    |
  | function foo(#          |                    |
  | function foo#()         | foo(               |
  | foo()?->bar# ();         | bar(              |
  | fo#o()->bar ();         | foo(               |
  :-------------------------:--------------------:

Return empty string if there is no valid sequence of characters."
  (let (start-pos)
    (save-excursion
      (skip-chars-backward "a-z0-9A-Z_\\\\")
      (setq start-pos (point))
      (skip-chars-forward "a-z0-9A-Z_\\\\")
      (skip-chars-forward " \t")
      (skip-chars-forward "(")
      (s-replace-all '((" " . "")
                       ("\t" . ""))
                     (buffer-substring-no-properties start-pos (point))))))

(defun ac-php-get-cur-word-with-dollar ()
  "Doc."
  (let (start-pos)
    (save-excursion
      (skip-chars-backward "\\$a-z0-9A-Z_")
      (setq start-pos (point))
      (skip-chars-forward "\\$a-z0-9A-Z_")
      (buffer-substring-no-properties start-pos (point)))))

(defun ac-php-get-cur-word-without-clean ()
  "Doc."
  (let (start-pos)
    (save-excursion
      (skip-chars-backward "\\$a-z0-9A-Z_\\\\")
      (setq start-pos (point))
      (skip-chars-forward "\\$a-z0-9A-Z_\\\\"))
    (buffer-substring-no-properties start-pos (point))))

(defun ac-php-show-tip(&optional _prefix)
  "Doc PREFIX."
  (interactive "P")
  ;; 检查是类还是 符号
  (let ((tags-data (ac-php-get-tags-data))
        symbol-ret
        type doc class-name access return-type member-info tag-name function-item file-pos)
    (setq symbol-ret (ac-php-find-symbol-at-point-pri tags-data))
    (when symbol-ret
      (setq type (car symbol-ret))
      (setq member-info (nth 3 symbol-ret))
      (cond
       ((string= type "class_member")
        (setq tag-name (aref member-info 1))
        (if (string= (aref member-info 0) "m")
            (setq doc (concat tag-name (aref member-info 2) ")"))
          (setq doc tag-name))

        (setq class-name (aref member-info 5))
        (setq return-type (aref member-info 4))
        (setq access (aref member-info 6))
        (popup-tip (concat (ac-php-clean-document doc) "\n\t[  type]:" return-type "\n\t[access]:" access "\n\t[  from]:" class-name)))
       ((string= type "user_function")
        (setq function-item (nth 3 symbol-ret))
        (setq tag-name (aref function-item 1))
        (if (ac-php--tag-name-is-function tag-name)
            (setq doc (concat tag-name (aref function-item 2) ")"))
          (setq doc (aref function-item 2)))

        (setq file-pos (aref function-item 3))

        (setq return-type (aref function-item 4))
        (popup-tip (concat "[" (if (string= "sys" file-pos) "system" "user") "]:" (ac-php-clean-document doc) "\n[  type]:" return-type)))))))

(defun ac-php-cscope-find-egrep-pattern (symbol)
  "Set `cscope-initial-directory' and run egrep over the cscope database SYMBOL."
  (interactive
   (list
    (let (cscope-no-mouse-prompts)
      (cscope-prompt-for-symbol "Find this egrep pattern " nil t t))))
  (let ((project-root-dir (ac-php--get-project-root-dir)))
    (if (or ac-php-use-cscope-flag
            (ac-php--get-use-cscope-from-config-file project-root-dir))
        (progn
          (setq cscope-initial-directory
                (ac-php--get-tags-save-dir project-root-dir))
          (cscope-find-egrep-pattern symbol))
      (message "need config: %s -> use-cscope:true" ac-php-config-file))))

(defun ac-php-eldoc-documentation-function ()
  "A function to provide ElDoc support.

Returns a doc string appropriate for the current context, or nil.
See `eldoc-documentation-function' for what this function is
supposed to do."

  (interactive "P")

  (let ((tags-data (ac-php-get-tags-data))
        symbol-ret
        type
        doc
        class-name
        access
        return-type
        member-info
        tag-name
        function-item
        member-info-len)
    (when tags-data
      (setq symbol-ret (ac-php-find-symbol-at-point-pri tags-data))
      (when symbol-ret
        (setq type (car symbol-ret))
        (setq member-info (nth 3 symbol-ret))
        (cond
         ((string= type "class_member")

          (setq member-info-len (length member-info))
          (setq tag-name (aref member-info 1))
          (if (string= (aref member-info 0) "m")
              (setq doc (concat
                         (propertize tag-name 'face 'font-lock-function-name-face)
                         (aref member-info 2) ")"))
            (setq doc
                  (propertize tag-name 'face 'font-lock-variable-name-face)))

          (setq class-name (ac-php--get-array-string member-info member-info-len 5))
          (setq return-type (aref member-info 4))
          (setq access (ac-php--get-array-string member-info member-info-len 6))
          (concat
           (propertize access 'face 'font-lock-keyword-face) " " class-name "::" doc ":" return-type))
         ((string= type "user_function")
          (setq function-item (nth 3 symbol-ret))
          (setq tag-name (aref function-item 1))
          (if (ac-php--tag-name-is-function tag-name)
              (setq doc (concat
                         (propertize (substring tag-name 0 -1) 'face 'font-lock-function-name-face)
                         "(" (aref function-item 2) ")"))
            (setq doc
                  (propertize (aref function-item 2) 'face 'font-lock-variable-name-face)))

          (setq return-type (aref function-item 4))

          (concat doc ":" return-type)))))))

(defun ac-php-show-cur-project-info ()
  "Show current project ac-php info ."
  (interactive)
  (let ((tags-arr (ac-php-get-tags-file)) tags-file tags-vendor-file project-root-dir file-attr file-last-time ( tags-data  (ac-php-get-tags-data ) )  vendor-tags-data)
    (if tags-arr
        (progn

          (setq tags-file (nth 1 tags-arr))
          (setq tags-vendor-file (nth 2 tags-arr))
          (setq project-root-dir (nth 0 tags-arr))
          (setq vendor-tags-data ( ac-php-load-data tags-vendor-file nil project-root-dir ))
          )
      (setq tags-file  (ac-php--get-common-json-file)))
    (when tags-file
      (setq file-attr (file-attributes tags-file))
      (setq file-last-time (format-time-string "%Y-%m-%d %H:%M:%S" (nth 5 file-attr))))
    (message (concat "root dir           : %s\n"
                     "config file        : %s%s\n"
                     "tags file          : %s\n"
                     "tags last gen time : %s\n"
                     "file count         : %s\n"
                     "define count       : %s\n"
                     "vendor file count  : %s\n"
                     "vendor define count: %s\n"
                     )
             project-root-dir
             project-root-dir
             ac-php-config-file
             tags-file
             file-last-time
             (length   (ac-php-g--file-list tags-data) )
             ( hash-table-count (ac-php-g--function-map tags-data) )
             (length   (ac-php-g--file-list vendor-tags-data) )
             ( hash-table-count (ac-php-g--function-map vendor-tags-data) )
             )))

;;; Initialization

(define-minor-mode ac-php-mode
  "Minor mode to enable autocompletion for the PHP language.

When called interactively, toggle `ac-php-mode'.  With prefix
ARG, enable `ac-php-mode' if ARG is positive, otherwise disable
it.

When called from Lisp, enable `ac-php-mode' if ARG is omitted,
nil or positive.  If ARG is `toggle', toggle `ac-php-mode'.
Otherwise behave as if called interactively.

Usually you shouldn't call this function manually.  It will be
called from Lisp when necessary."

  ;; The indicator for the mode line.
  :lighter ac-php-mode-line
  ;; The minor mode should be buffer-local
  :global nil
  ;; Custom group name to use in all generated ‘defcustom’ forms
  :group 'ac-php
  ;; The initial value
  (cond
   (ac-php-mode
    ;; Enable `ac-php-mode'
    (setq ac-php-gen-tags-flag t))
   (t
    ;; Disable `ac-php-mode'
    (setq ac-php-gen-tags-flag nil))))

;;;###autoload
(defun ac-php-core-eldoc-setup ()
  "Enable the ElDoc support for the PHP language.
Configure the variable `eldoc-documentation-function' and
call the command `eldoc-mode'."
  (interactive)
  (setq-local eldoc-documentation-function
              #'ac-php-eldoc-documentation-function)
  (eldoc-mode +1))

;; Local Variables:
;;  flycheck-disabled-checkers: (emacs-lisp-package)
;; End:

(provide 'ac-php-core)

;;; ac-php-core.el ends here
