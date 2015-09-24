;;; ac-php.el --- Auto Completion source for php for GNU Emacs

;; Copyright (C) 2014 - 2015 jim 

;; Author: xcwenn@qq.com [https://github.com/xcwen]
;; URL: https://github.com/xcwen/ac-php
;; Keywords: completion, convenience, intellisense
;; Package-Requires: ((emacs "24") ( php-mode "1") (auto-complete "1.4.0") (yasnippet "0.8.0") (xcscope "1") (s "1") (f "1"))



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

;; thanks auto-complete-clang , rtags ( ac-php-location-stack-index ) , auto-java-complete  ( ac-php-remove-unnecessary-items-4-complete-method   )

;;; Commentary: 
;; Auto Completion source for php. 
;; Only support  Linux and OSX , not support Windows
;; More info and **example** at : https://github.com/xcwen/ac-php 
;;
;; ============================================== For add 
;; add to .emacs:
;; 
;;(add-hook 'php-mode-hook '(lambda ()
;;                            (auto-complete-mode t)
;;                            (require 'ac-php)
;;                            (setq ac-sources  '(ac-source-php ) )
;;                            (yas-global-mode 1)
;;
;;                            (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
;;                            (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
;;                            ))
;;
;;
;; ============================================== For test
;; save it as .emacs  then restart emacs  and open php file to test
;;
;;(setq package-archives
;;      '(("melpa" . "http://melpa.milkbox.net/packages/")) )
;;
;;(package-initialize)
;;(unless (package-installed-p 'ac-php )
;;  (package-refresh-contents)
;;  (package-install 'ac-php )
;;  )
;;(require 'cl)
;;(require 'php-mode)
;;(add-hook 'php-mode-hook '(lambda ()
;;                            (auto-complete-mode t)
;;                            (require 'ac-php)
;;                            (setq ac-sources  '(ac-source-php ) )
;;                            (yas-global-mode 1)
;;
;;                            (define-key php-mode-map  (kbd "C-]") 'ac-php-find-symbol-at-point)   ;goto define
;;                            (define-key php-mode-map  (kbd "C-t") 'ac-php-location-stack-back   ) ;go back
;;                            ))
;;
;; 

;;; Code:


(provide 'ac-php)


(require 'json)
(require 's)
(require 'f)

(require 'ac-php-comm-tags-data )

(if (featurep 'auto-complete) (require 'auto-complete) )
(if (featurep 'php-mode)  (require 'php-mode))
(if (featurep 'popup) (require 'popup) )

(defvar ac-php-executable (concat  (file-name-directory load-file-name) "phpctags"))

(defvar ac-php-debug-flag nil)

;;(setq ac-php-debug-flag t)
;;(setq ac-php-debug-flag nil)
;; (setq debug-on-error t )

;; (setq ac-php-comm-tags-data-list nil )
;; (setq debug-on-error nil )

(defmacro ac-php--debug (  fmt-str &rest args )
  `(if ac-php-debug-flag
       (message (concat "[AC-PHP-DEBUG]:" ,fmt-str ) ,@args )
       ))

(defvar ac-php-use-cscope-flag nil)

(defcustom ac-php-cscope 
  (executable-find "cscope")
  "*Location of cscope executable"
  :group 'auto-complete
  :type 'file)
(defface ac-php-candidate-face
  '((t (:background "lightgray" :foreground "navy")))
  "Face for php candidate"
  :group 'auto-complete)

(defface ac-php-selection-face
  '((t (:background "navy" :foreground "white")))
  "Face for the php selected candidate."
  :group 'auto-complete)



;;data 
(defvar ac-php-tag-last-data-list nil) ;;(("/home/xxx/projecj/.tags".(  1213141011  data )   ))

(defvar ac-php-word-re-str "[0-9a-zA-Z_\\]+" )

(defvar ac-php-location-stack-index 0)
(defvar ac-php-location-stack nil)

(defvar ac-php-max-bookmark-count 500 )
(defun ac-php-location-stack-push ()
  (let ((bm (ac-php-current-location)))
    (while (> ac-php-location-stack-index 0)
      (decf ac-php-location-stack-index)
      (pop ac-php-location-stack))
    (unless (string= bm (nth 0 ac-php-location-stack))
      (push bm ac-php-location-stack)
      (if (> (length ac-php-location-stack) ac-php-max-bookmark-count)
          (nbutlast ac-php-location-stack (- (length ac-php-location-stack) ac-php-max-bookmark-count)))))
  )


;;function 
(defun ac-php-goto-line-col (line column)
  (goto-char (point-min))
  (forward-line (1- line))
  (beginning-of-line)
  (forward-char (1- column)))

(defun ac-php-current-location (&optional offset)
  (format "%s:%d:%d" (or (buffer-file-name) (buffer-name))
          (line-number-at-pos offset) (1+ (- (or offset (point)) (point-at-bol)))))
(defun ac-php--string=-ignore-care( str1 str2  )
  (s-equals?(s-upcase str1 ) (s-upcase str2 ))
  ;;(not (integer-or-marker-p ( compare-strings  str1  0 nil str2  0 nil t ))  )
  )

(defun ac-php-find-file-or-buffer (file-or-buffer &optional other-window)
  (if (file-exists-p file-or-buffer)
      (if other-window
          (find-file-other-window file-or-buffer)
        (find-file file-or-buffer))
    (let ((buf (get-buffer file-or-buffer)))
      (cond ((not buf) (message "No buffer named %s ;you can M-x: ac-php-remake-tags-all  fix it " file-or-buffer))
            (other-window (switch-to-buffer-other-window file-or-buffer))
            (t (switch-to-buffer file-or-buffer))))))


(defun ac-php-goto-location (location &optional other-window )
  "Go to a location passed in. It can be either: file,12 or file:13:14 or plain file"
  ;; (message (format "ac-php-goto-location \"%s\"" location))
  (when (> (length location) 0)
    (cond ((string-match "\\(.*\\):\\([0-9]+\\):\\([0-9]+\\)" location)
           (let ((line (string-to-number (match-string-no-properties 2 location)))
                 (column (string-to-number (match-string-no-properties 3 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;;(run-hooks ac-php-after-find-file-hook)
             (ac-php-goto-line-col line column)
             t))
          ((string-match "\\(.*\\):\\([0-9]+\\)" location)
           (let ((line (string-to-number (match-string-no-properties 2 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;;(run-hooks ac-php-after-find-file-hook)
             (goto-char (point-min))
             (forward-line (1- line))
             t))
          ((string-match "\\(.*\\),\\([0-9]+\\)" location)
           (let ((offset (string-to-number (match-string-no-properties 2 location))))
             (ac-php-find-file-or-buffer (match-string-no-properties 1 location) other-window)
             ;;(run-hooks ac-php-after-find-file-hook)
             (goto-char (1+ offset))
             t))
          (t
           (if (string-match "^ +\\(.*\\)$" location)
               (setq location (match-string-no-properties 1 location)))
           (ac-php-find-file-or-buffer location other-window)))
    ;;(ac-php-location-stack-push)
    ))





(defsubst ac-php-clean-document (s)
  (when s
    (setq s (replace-regexp-in-string "<#\\|#>\\|\\[#" "" s))
    (setq s (replace-regexp-in-string "#\\]" " " s)))
  s)
(defun  ac-php--tag-name-is-function ( tag-name )
  (s-matches-p "(" tag-name )
    )

(defun ac-php-template-document (item)
  (if (stringp item)
      (let (doc  tag-type return-type access from-class)
        (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help item)))
        )
  ))

(defun ac-php-document (item)
  (if (stringp item)
      (let (doc  tag-type return-type access from-class)
        (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help item)))
        (setq tag-type (get-text-property 0 'ac-php-tag-type item))
        (setq return-type (get-text-property 0 'ac-php-return-type item))
        (setq access (get-text-property 0 'ac-php-access item))
        (setq from-class (get-text-property 0 'ac-php-from item))
        (if ( ac-php--tag-name-is-function item) 
            (setq doc (concat item  doc ")" ) )
          (setq doc item )
          )



        (cond
         ( (or (string= tag-type "p") ( string= tag-type "m") ( string= tag-type "d")  )
           (format "%s\n\t[  type]:%s\n\t[access]:%s\n\t[  from]:%s" doc  return-type access  from-class  ) )
         (return-type 
          (format "%s  %s " return-type doc   ) )
         (t
          doc))
        ))
  )



(defun ac-php-check-not-in-string-or-comment (pos)
  "ac-php-check-in-string-or-comment"
  (save-excursion (if  (nth 8 (syntax-ppss pos))  nil  t ))
  ) 
(defun ac-php-check-not-in-comment (pos)
  "ac-php-check-in-string-or-comment"
  (save-excursion (if  (nth 4 (syntax-ppss pos))  nil  t ))
  ) 


(defun ac-php-split-string-with-separator(str regexp &optional replacement omit-nulls)
  "this function is a tool like split-string,
  but it treat separator as an element of returned list
  for example (ac-php-split-string-with-separator abc.def.g \"\\.\" \".\")
  will return '(\"abc\" \".\" \"def\" \".\" \"g\" )"
  (when str
    (let (split-list  substr match-end)
      (if  (string-match regexp str)
          (progn
            (while (string-match regexp  str)
              (setq match-end (match-end 0))
              (setq  substr (substring-no-properties str 0 (- match-end 1)))
              (when (or (not omit-nulls) (> (length substr ) 0))
                (setq split-list (append split-list (list  substr))) )
              (setq split-list (append split-list (list (or replacement regexp))))
              (setq str (substring-no-properties str  match-end)))
            (when (or (not omit-nulls) (> (length str ) 0))
              (setq split-list (append split-list (list str)))))
        (setq split-list (list str)))
      split-list)))
(defun ac-php--get-clean-node( paser-data &optional check-len )
    "clean  before ';'  "
    (let ((i 0 )  ret-data  item )
      (unless check-len
        (setq check-len (length paser-data) ) )
    (while (< i check-len )  
      (setq item (nth i paser-data ) )
      (if (and (stringp item   )
               (string= item ";" )
               )
          (setq ret-data nil)
        (push item ret-data)
        ) 
      (setq i (1+ i))
      )


    (ac-php--debug "clean-node:%S" ret-data)
    (reverse ret-data)
    ))
(defun ac-php--get-node-paser-data ( paser-data)
  (let ((last-item (nth (1- (length paser-data)) paser-data )) ret-data )

    (if ( and ( stringp last-item )
              (string=  last-item  "__POINT__" ))
        (let ((i 0 )
              (check-len (1- (length paser-data)))
              item )
          (setq ret-data (ac-php--get-clean-node  paser-data check-len ) )
            )
      (when last-item 
        (setq ret-data (ac-php--get-node-paser-data last-item )) ))
    ret-data
    ))
(defun ac-php--get-key-list-from-paser-data( paser-data)
  (let (
        (frist-key (nth 0  paser-data ))
        item
        (i 1)
        (ret)
        (len-paser-data (length paser-data)))
    ;;处理list

    
    (if (and (listp  frist-key)  frist-key   )
        (progn
          (setq ret  (ac-php--get-clean-node (ac-php--get-key-list-from-paser-data frist-key )) )
        )
      (setq ret  (list frist-key) )
      )


    (setq i 1)
    (while (< i len-paser-data)
      (setq item (nth i paser-data) )
      (cond
       ((and (stringp item) ( and (<(1+ i) len-paser-data ) (listp (nth (1+ i) paser-data))  ) )
        ;;function
        (setq ret (append ret  (list (concat item "("))))
        (setq i (+ i 2) ))

       ((stringp item)
        ;;var
        (setq ret (append ret  (list item)))
        (setq i (1+ i) ))
       (t (setq i (1+ i) ))
      ))
    ret
    ))

(defun ac-php-remove-unnecessary-items-4-complete-method (splited-line-items)
  (let ((need-add-right-count 1  )
        ( item-count (length splited-line-items ))
        (i 0)
        item
        (elisp-str "(")
        paser-data
        ret
        )
    
    (while (< i item-count )
      (setq item (nth i splited-line-items) )
      (cond
       ((string= "(" item )
        (setq elisp-str (concat elisp-str "(" )   )
        (setq need-add-right-count (1+ need-add-right-count ) )
        )
       ((string= ")" item )
        (setq elisp-str (concat elisp-str ")" )   )
        (setq need-add-right-count (1- need-add-right-count ) )
        )
       (t
        (setq elisp-str (concat elisp-str "\"" (s-replace "\\"  "\\\\" item )  "\" " )  )))
      (setq i (1+ i))
      )

    (if (> need-add-right-count  0)
        (progn
          (setq  elisp-str (concat  elisp-str "\"__POINT__\"") )
          (setq i 0)
          (while (< i need-add-right-count )
            (setq  elisp-str (concat  elisp-str ")" ))

            (setq i (1+ i))
            )
          )
      (setq  elisp-str "()"  ))
     (setq paser-data (read  elisp-str) )
     (setq paser-data (ac-php--get-node-paser-data  paser-data  ))
     (setq ret (ac-php--get-key-list-from-paser-data  paser-data) )
     ret
    ))

(defun ac-php--get-class-full-name-in-cur-buffer ( first-key function-list get-return-type-flag)
    "DOCSTRING"
  (let (cur-namespace tmp-name ret-name tmp-ret)
    (let (  split-arr   cur-class-name )
      (ac-php--debug " ac-php--get-class-full-name-in-cur-buffer  frist-key:%s" first-key )
      
      
      (setq split-arr (s-split-up-to "\\\\"  (ac-php-clean-namespace-name first-key ) 2 ))
      (cond
       ((= 2 (length split-arr))

        (setq cur-namespace (nth 0 split-arr) )
        (setq cur-class-name (nth 1 split-arr) )
        (setq tmp-name (ac-php-get-use-as-name  cur-namespace ) )
        (ac-php--debug "tmp-name 22 %s" tmp-name)
        (when tmp-name (setq tmp-name (concat tmp-name "\\" cur-class-name ) ) ))

       ((= 1 (length split-arr))

        ;;check use as 
        (setq cur-class-name (nth 0 split-arr) )
        (setq  tmp-name (ac-php-get-use-as-name  cur-class-name ) )

        (ac-php--debug "  length 1   tmp-name=%s" tmp-name  )
        ;;check cur-namespace
        (unless tmp-name
          (let ((cur-namespace (ac-php-get-cur-namespace-name)))
            (if cur-namespace
                (setq tmp-name (concat  cur-namespace "\\" first-key ) )
              (setq tmp-name first-key )
              ))) 

        )))

    ;; current-namespace
    (ac-php--debug "==to check %s" tmp-name )
    (when tmp-name
      
      (setq tmp-ret  (ac-php--get-item-from-funtion-list  (ac-php-clean-namespace-name  tmp-name ) function-list ))

      (ac-php--debug "11 tmp-ret %S" tmp-ret)
      (if tmp-ret
          (if get-return-type-flag 
              (setq ret-name  (nth 4 tmp-ret ) )
            (setq ret-name  (nth 1 tmp-ret ) )
            )
        ))
    (unless ret-name
      (setq tmp-ret  (ac-php--get-item-from-funtion-list  (ac-php-clean-namespace-name  first-key ) function-list ))

      (ac-php--debug "22 tmp-ret %S" tmp-ret)
      (if tmp-ret 
          (if get-return-type-flag 
              (setq ret-name  (nth 4 tmp-ret ) )
            (setq ret-name  (nth 1 tmp-ret ) )
            )
        ))

    (ac-php--debug " ac-php--get-class-full-name-in-cur-buffer ret-name %s" ret-name)
    ret-name
    ))

(defun ac-php-split-line-4-complete-method(line-string  )
  "this function is used to complete method ,first this function will split line-string to small items
for example : suppose line-string is
System.getProperty(str.substring(3)).to
then this function split it to
'System' '.' 'getProperty' '(' 'str' '.' 'substring' '(' '3' ')' ')' '.' 'to' "
  (save-excursion
    (let (  (stack-list nil))
      (setq line-string  (replace-regexp-in-string   "\".*?\"" "String" line-string))
      (setq line-string  (replace-regexp-in-string   "[.]"   ";"       line-string))
      ;;  do : without ::
      (setq line-string  (replace-regexp-in-string   "\\([^:]\\):\\([^:]\\)"   ";\\1"  line-string))
      (setq line-string  (replace-regexp-in-string   "[ \t]*->[ \t]*" "."       line-string))
      (setq line-string  (replace-regexp-in-string   "[ \t]*::[ \t]*" "::."       line-string))

      (setq line-string  (replace-regexp-in-string   "\\bnew\\b\\|\\breturn\\b\\|\\becho\\b\\|\\bint\\b\\|\\bfloat\\b\\|\\bdouble\\b\\|\\bstring\\b\\|\\bcase\\b"    ";"  line-string))

      (setq line-string  (replace-regexp-in-string   "\\$" ""  line-string))
      (setq line-string  (replace-regexp-in-string   "!?=>?\\|<=?\\|>=?\\|=" ";"  line-string))
      (setq line-string  (replace-regexp-in-string    "[&|!,?^+/*\-]"  ";"  line-string))

 
      ;;split line-string with "." ,but add "." as an element at its position in list
      (setq stack-list (ac-php-split-string-with-separator  line-string "[ \t]*\\.[ \t]*"  "." t))
      ;;split each element  with "(" ,but add "(" as an element at its position in list
      ;;and merge all the list in a list
      (let((ele)(tmp-list))
        (dolist (ele stack-list)
          (setq tmp-list (append tmp-list (ac-php-split-string-with-separator ele "[{}]"  ";"  t))))
        (setq stack-list tmp-list))
      (ac-php--debug "stack-list 2 :%S" stack-list)


      (let((ele)(tmp-list))
        (dolist (ele stack-list)
          (setq tmp-list (append tmp-list (ac-php-split-string-with-separator ele "[>)]\\|]"  ")"  t))))
        (setq stack-list tmp-list))
      (ac-php--debug "stack-list 2 :%S" stack-list)

      (let ((ele)(tmp-list))
        (dolist (ele stack-list)
          (setq tmp-list (append tmp-list (ac-php-split-string-with-separator ele "[<([]"  "("  t))))
        (setq stack-list tmp-list))

      (ac-php--debug "stack-list 3 :%S" stack-list)

      (let ((ele)(tmp-list))
        (dolist (ele stack-list)
          (setq tmp-list (append tmp-list (ac-php-split-string-with-separator ele ";"  ";"  t))))
        (setq stack-list tmp-list))



      (let ((ele)(tmp-list))
        (dolist (ele stack-list)
          (setq tmp-list (append tmp-list (split-string ele "[ \t]+"  t))))
        (setq stack-list tmp-list))

      (setq stack-list stack-list )

      ))
  )


(defun ac-php-get-syntax-backward ( re-str  pos  &optional  in-comment-flag  min-pos )
  "DOCSTRING"
  (let (line-txt ret-str find-pos need-find-flag  old-case-fold-search  search-pos)  
    (setq  old-case-fold-search case-fold-search )
    (setq need-find-flag t )

    (save-excursion
      (while  need-find-flag
        (if (setq search-pos (re-search-backward  re-str  min-pos t 1) )
            (progn
              (when (if in-comment-flag
                        (not (ac-php-check-not-in-comment (point) ) )
                      (ac-php-check-not-in-string-or-comment (point))) 
                (setq line-txt (buffer-substring-no-properties (line-beginning-position) (line-end-position)))
                (when (string-match   re-str    line-txt)
                  (setq  ret-str  (match-string pos line-txt))
                  (setq  ret-str (propertize ret-str 'pos  search-pos))

                  (setq need-find-flag nil))))
          (setq need-find-flag nil)
          )
        )
      )
    (setq   case-fold-search old-case-fold-search )
    (ac-php--debug "regstr=:%s; min-pos=%S ret-str:%s" re-str min-pos ret-str )
    ret-str
    ))




(defun ac-php-get-cur-class-name ()
  "DOCSTRING"
  ( ac-php-get-syntax-backward "^[ \t]*\\(abstract[ \t]+\\|final[ \t]+\\)*class[ \t]+\\([a-zA-Z0-9_]+\\)" 2 ))
(defun ac-php-clean-namespace-name (namespace-name)
  (if (and (stringp namespace-name)
           (> (length namespace-name)   1)
           ( string=  (substring-no-properties  namespace-name 0 1  ) "\\" ) )
        ( substring-no-properties namespace-name 1 )
      namespace-name))

(defun ac-php-get-cur-full-class-name ()
  "DOCSTRING"
  (let (class-name namespace-name )
    (setq class-name (ac-php-get-cur-class-name) )
    (setq namespace-name (ac-php-clean-namespace-name  (ac-php-get-cur-namespace-name)) )

    (if class-name
        (concat namespace-name  (if namespace-name "\\" "" )  class-name )
      nil
        )))

(defun ac-php-get-cur-namespace-name ()
  (interactive)
  "DOCSTRING"
  ( ac-php-get-syntax-backward  (concat "^[ \t]*namespace[ \t]+\\(" ac-php-word-re-str "\\)")  1  )

  )


(defun ac-php-get-use-as-name (item-name )
  "DOCSTRING"
  (let ()
   (setq item-name (nth 0 (s-split "(" item-name  )) )
  (or
   ( ac-php-get-syntax-backward (concat "^[ \t]*use[ \t]+\\(" ac-php-word-re-str "\\" item-name "\\)[ \t]*;") 1  nil  )
   ( ac-php-get-syntax-backward (concat "^[ \t]*use[ \t]+\\(" ac-php-word-re-str "\\)[ \t]+as[ \t]+" item-name "[ \t]*;" ) 1 nil ) )
  ))

(defun ac-php--get-all-use-as-name-in-cur-buffer () "make a regex to match   use statements "
  (let ( ret-list (search-re (concat "use[ \t]+" ac-php-word-re-str ".*;")  ) line-txt match-ret )
    (save-match-data
      (save-excursion
        (goto-char (point-min))
        (while (re-search-forward search-re  nil t )
          (setq line-txt (buffer-substring-no-properties
                          (line-beginning-position)
                          (line-end-position )))
          (ac-php--debug "line-text:%s" line-txt)
          
           (setq match-ret (s-match   (concat "use[ \t]+\\(" ac-php-word-re-str "\\)[ \t]+as[ \t]+\\("ac-php-word-re-str "\\)[ \t]*;") line-txt ))
          (if match-ret
              (add-to-list 'ret-list (list  (nth 1 match-ret) (nth 2 match-ret)   ))
            (progn
              (setq match-ret (s-match   (concat "use[ \t]+\\(" ac-php-word-re-str "\\)[ \t]*;") line-txt ))
              (when match-ret
                (let ((key-arr (s-split "\\\\" (nth 1 match-ret) ) ))
                  (ac-php--debug "key-arr %S " key-arr)
                  
                  (add-to-list 'ret-list (list (nth 1 match-ret)  (nth (1- (length key-arr)) key-arr )   ))))))
          
          (end-of-line))))
    ret-list ))
(defun ac-php-toggle-debug ()
    "DOCSTRING"
  (interactive)
  (let ()
    (setq ac-php-debug-flag  (not ac-php-debug-flag) )
    (message "set:  ac-php-debug-flag: %s " ac-php-debug-flag )
    ))

(defun ac-php-test ()
    "DOCSTRING"
  (interactive)
  (let (v)
    (setq v (ac-php--get-all-use-as-name-in-cur-buffer  ))
    (ac-php--debug "%S" v)
    
    ))





(defun ac-php-get-class-at-point( &optional pos  )

  (let (line-txt old-line-txt  key-line-txt  key-list   tmp-key-list frist-class-name  frist-key  ret-str frist-key-str  (class-list (nth 0 (ac-php-get-tags-data)) ) )
    
    ;; default use cur point 
    (unless  pos (setq pos (point) ))

    (setq line-txt (s-trim (buffer-substring-no-properties
                    (line-beginning-position)
                     pos  )))

    (setq old-line-txt line-txt)

    (if (ac-php-check-not-in-string-or-comment pos)
        (progn
          (setq key-list (ac-php-remove-unnecessary-items-4-complete-method
                          (ac-php-split-line-4-complete-method line-txt ))) 

          (ac-php--debug "ac-php-remove-unnecessary-items-4-complete-method:%S" key-list  )
          ;; out of function like : class Testb  extends test\Testa[point]
          (if (not (and (stringp (nth 1 key-list ) )
                        (string= "."  (nth 1 key-list )  )
                        ))
              (setq  key-list nil )))
      (setq  key-list nil ))



    (when  key-list  
      (setq frist-key-str (nth 0 (ac-php--get-item-info (nth 0  key-list)   )))
      ;;检查 :: 
      (if (and (string-match  "::"  frist-key-str  ) (not (string-match  "\\/\\*"  line-txt ) ))
          (progn 
            (setq frist-key (substring-no-properties  frist-key-str  0 -2  ) ) 
            (setq frist-key (ac-php-clean-namespace-name frist-key) )
            (setq frist-class-name  frist-key  )
            (cond
             ((string= frist-key "parent" ) 
              (setq frist-class-name (concat (ac-php-get-cur-full-class-name) ".__parent__" ) ))
             ((or (string= frist-key "self" ) (string= frist-key "static" )   )
              (setq frist-class-name (concat (ac-php-get-cur-full-class-name) ) ))
             ((string-match  "\$[a-zA-Z0-9_]*[\t ]*::" old-line-txt  )  (setq frist-class-name nil))
             ))
        (progn
          (setq frist-key  frist-key-str )
          (setq frist-key (ac-php-clean-namespace-name frist-key))
          
          (when (and(not frist-class-name) (or (string= frist-key "this")  ) ) 
            (setq frist-class-name (ac-php-get-cur-full-class-name)  ))

          ;;check for new define  /* @var $v  class_type  */
          (unless frist-class-name
            (setq frist-class-name  (ac-php-clean-namespace-name
                                     (ac-php-get-syntax-backward
                                      (concat "@var[\t ]+"  "$" frist-key "[\t ]+\\("
                                              ac-php-word-re-str "\\)" )
                                      1 t
                                      (save-excursion  (beginning-of-defun)  (beginning-of-line) )))))

          ;;check  function xxx (classtype $val)  
          ;;check   catch ( classtype $val) 
          (unless frist-class-name
            (setq frist-class-name  (ac-php-clean-namespace-name
                                     (ac-php-get-syntax-backward
                                      (concat "\\(" ac-php-word-re-str "\\)" "[\t ]+" "$" frist-key  "[ \t]*[),]" )
                                      1 nil 
                                      (save-excursion  (beginning-of-defun) (beginning-of-line)  )))))



          ;; check $v = new .... or $v = $this->sadfa() ;
          (unless frist-class-name
            (let (define-str symbol-ret symbol-type )
              (setq define-str (ac-php-get-syntax-backward
                                (concat   "$" frist-key "[\t ]*=\\([^=]*\\)[;]*" )
                                1 nil 
                                (save-excursion  (beginning-of-defun)  (beginning-of-line)  )) )
              (when define-str
                (save-excursion 
                  (goto-char (get-text-property 0 'pos  define-str))
                  (end-of-line)    
                  
                  (setq line-txt (buffer-substring-no-properties
                                  (line-beginning-position)
                                  (line-end-position )))
                  

                  (if  (string-match "(" line-txt)
                      (re-search-backward ".[ \t]*(" ) ;; func
                    (re-search-backward ".[ \t]*;" ) ;;  p
                      )
                  ;;(backward-char 1)
                  (ac-php--debug " ===== define-str :%s pos=%d check_pos=%d"  define-str (get-text-property 0 'pos  define-str) (point) )
                  (setq symbol-ret (ac-php-find-symbol-at-point-pri))
                  (when symbol-ret
                    (setq symbol-type  (car symbol-ret) )
                    (when (or (string= symbol-type "class_member" )
                            (string= symbol-type "user_function" ) )
                      
                      (setq frist-class-name  (nth 2 symbol-ret)  )

                      ) 
                    )
                ))
            ))
          

          (unless frist-class-name (setq frist-class-name frist-key)))))


    ;;fix use-as-name ,same namespace
    (when ( and frist-class-name
                (= 1 (length  (s-split "\\."  frist-class-name ) ) )
                )
      (setq frist-class-name (ac-php--get-class-full-name-in-cur-buffer
                              frist-class-name
                              (nth 1 (ac-php-get-tags-data )) t ) ))


    

    (ac-php--debug "===frist-class-name :%s" frist-class-name)
    
    (if frist-class-name 
        (progn
          (setq ret-str  (concat frist-class-name ))

          (dolist (field-value (cdr key-list) )
            ;;(when  (not (string= "." field-value)) 
            (setq ret-str  (concat  ret-str  field-value )))
          ;;)
          ret-str)
      (if (>(length   key-list ) 1) "null" nil) )))



(defun ac-php-candidate-class ( tags-data key-str-list  )
  ;;得到变量
  (let ( ret-list key-word output-list  class-name  (class-list (nth 0 tags-data)) (inherit-list (nth 2 tags-data))  item-list check-item )
    (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list ))
    (setq class-name (ac-php-get-class-name-by-key-list  tags-data key-str-list ))

    (progn

      (setq  output-list (ac-php-get-class-member-list  class-list inherit-list  class-name ) )
      (ac-php--debug " 22 class-name:%s output-list= %S" class-name output-list )
      (mapc (lambda (x)
                (setq key-word   (concat (nth 1 x )  (if(string=  (nth 0 x )  "m" ) "(" ) ))
                (setq check-item  (concat  (nth 0  x ) "_" key-word     ))
                (if (assoc-string  check-item item-list t ) 
                    (progn
                      )
                  (progn
                    (setq  item-list (append  (list key-word nil) item-list))


                    (setq key-word (propertize key-word 'ac-php-help   (nth 2  x ) ))


                    (setq key-word (propertize key-word 'ac-php-return-type (nth 4  x ) ))
                    (setq key-word (propertize key-word 'ac-php-tag-type (nth 0  x ) ))
                    (setq key-word (propertize key-word 'ac-php-access (nth 6  x ) ))
                    (setq key-word (propertize key-word 'ac-php-from (nth 5  x ) ))
                    ;;(setq key-word (propertize key-word 'summary  (concat  (nth 0  x ))    ))
                    ;;(setq key-word (propertize key-word 'summary  (concat (nth 5  x ) ":" (nth 0  x ))    ))
                    (setq key-word (propertize key-word 'summary  (nth 4  x )  ))
                    (push key-word ret-list  )))

                
                nil
                ) output-list )
      )

    (ac-php--debug " ret-list  = %S" ret-list)
    ret-list))
(defun ac-php--get-item-from-funtion-list (  key-word function-list )
  "DOCSTRING"
  (let (find-item )
    (dolist (function-item function-list )
      (when (ac-php--string=-ignore-care   key-word (nth 1 function-item )  )
        (setq find-item function-item )
        (return)))
    find-item
    ))

(defun ac-php-candidate-other ( tags-data)
  
  (let (ret-list ( cur-word  (ac-php-get-cur-word-without-clean )) cur-word-len  cmp-value  start-word-pos (function-list (nth 1 tags-data )  ) key-word func-name  end-flag  )

    (setq cur-word-len (length cur-word ))
    (setq start-word-pos (- cur-word-len (length ac-prefix) ) )

    ;;user func + class  
    (if ( string= (substring-no-properties cur-word 0 1 ) "\\")
        (progn 
          (setq cur-word (substring-no-properties cur-word 1 ))
          (setq end-flag (string= (substring-no-properties cur-word  -1   )  "\\" ))
          (dolist (function-item function-list )
            (when (s-prefix-p  cur-word (nth 1 function-item )  t )
              (if end-flag
                  (setq key-word (concat "\\" (substring-no-properties (nth  1  function-item )  )))
                (setq key-word  (substring-no-properties (nth  1  function-item )  (1- start-word-pos )))) 

              (setq key-word (propertize key-word 'ac-php-help  (nth 2  function-item ) ))
              (setq key-word (propertize key-word 'ac-php-return-type   (nth 4  function-item ) ))
              (setq key-word (propertize key-word 'summary   (nth 4  function-item ) ))
              (push key-word ret-list  )
              )))
      (progn 
        ;;use as 
        (dolist ( use-item (ac-php--get-all-use-as-name-in-cur-buffer  ) )
          (when (s-prefix-p  cur-word (nth 1 use-item ) t )
            (setq key-word  (substring-no-properties (nth  1  use-item ) start-word-pos  ))
            (setq key-word (propertize key-word 'ac-php-tag-type (nth 0  use-item ) ))
            (setq key-word (propertize key-word 'ac-php-help  (nth 1  use-item ) ))
            (setq key-word (propertize key-word 'ac-php-return-type   (nth 0  use-item ) ))
            (setq key-word (propertize key-word 'summary   (nth 0  use-item ) ))
            (push key-word ret-list  )
            ))
        ;;cur namespace
        (let ((cur-namespace (ac-php-get-cur-namespace-name)) cur-full-fix   start-word-pos-with-namespace   )
          (when cur-namespace
            (setq cur-full-fix (concat cur-namespace "\\" cur-word  ) )
            (setq start-word-pos-with-namespace (+  start-word-pos (length cur-namespace  ) 1 ) )
            (ac-php--debug "=== %s %S" cur-full-fix start-word-pos-with-namespace )
            
            (dolist (function-item function-list )
              
              (when (s-prefix-p  cur-full-fix  (nth 1 function-item )  t )
                (setq key-word  (substring-no-properties (nth  1  function-item ) start-word-pos-with-namespace  ))
                (setq key-word (propertize key-word 'ac-php-help  (nth 2  function-item ) ))
                (setq key-word (propertize key-word 'ac-php-return-type   (nth 4  function-item ) ))
                (setq key-word (propertize key-word 'ac-php-tag-type (nth 0  function-item ) ))
                (setq key-word (propertize key-word 'summary   (nth 4  function-item ) ))
                (push key-word ret-list  )
                ))))
        

        
        ;;common
        (dolist (function-item function-list )
          
          (when (s-prefix-p  cur-word (nth 1 function-item )  t  )
            (setq key-word  (substring-no-properties (nth  1  function-item ) start-word-pos  ))
            (setq key-word (propertize key-word 'ac-php-help  (nth 2  function-item ) ))
            (setq key-word (propertize key-word 'ac-php-return-type   (nth 4  function-item ) ))
            (setq key-word (propertize key-word 'ac-php-tag-type (nth 0  function-item ) ))
            (setq key-word (propertize key-word 'summary   (nth 4  function-item ) ))
            (push key-word ret-list  )
            ))
        )) 
    ret-list))
;;; ==============BEGIN
(defun ac-php-find-php-files ( work-dir regex also-find-subdir )
  "get all php file list"
  (let (results sub-results files file-name file-dir-flag file-change-time file-change-unixtime )
    (setq files (directory-files-and-attributes work-dir t))
    (dolist  (file-item  files )
      (setq file-name  (nth 0 file-item ) )
      (setq file-dir-flag  (nth 1 file-item ) )
      (setq file-change-time (nth 6 file-item ) )

      (if (stringp  file-dir-flag  );;link
          (setq  file-dir-flag (file-directory-p file-dir-flag )))


      (when (and (not file-dir-flag) ;;file
                 (string-match  regex file-name )
                 )
        
        (setq file-change-unixtime (+ (* (nth 0 file-change-time )  65536  ) (nth 1 file-change-time )   ) )
        (if results
            (nconc results (list (list file-name  file-change-unixtime)) )
          (setq results  (list (list file-name  file-change-unixtime) ))))

      (when ( and   file-dir-flag
                    ;;(not (string= "."   (file-name-base file-name)  ))
                    ;;(not (string= ".."   (file-name-base file-name)  ))
                    (not (string= "."  (substring (file-name-base file-name)  0 1 ))) ;; not start with "."
                    ) 
        (when also-find-subdir
          (setq sub-results  (ac-php-find-php-files file-name regex also-find-subdir ) )

          (if results
              (nconc results sub-results)
            (setq results sub-results)))
        ))
    results 
    ))
(defun ac-php--clean-return-type (return-type)
  (when return-type 
  (ac-php-clean-namespace-name (s-trim (replace-regexp-in-string "|.*" "" return-type ) ) ))
  )

(defun ac-php-gen-data ( tags-list project-dir-len  file-type)
  "gen-el-data"
  (let ( base-tags-data
        (class-list  )
        (function-list )
        (inherit-list  )
        (file-start-pos project-dir-len ) (count 0 )  add-class-list  )

    (setq  base-tags-data (if (string= file-type  "self"  )
                              (ac-php-get-tags-data t)  
                            ac-php-comm-tags-data-list  
                            ))
    
    (setq class-list  (nth 0 base-tags-data) )
    (setq function-list (nth 1 base-tags-data) )
    (setq inherit-list  (nth 2 base-tags-data) )

    (message "tags-list deal .... ")

    (dolist (line-data tags-list)
      (let (
            (tag-name (nth 0  line-data ))
            (file-pos (concat (substring  (nth 1  line-data )  file-start-pos ) ))
            (doc (nth 2  line-data ))
            (tag-type (nth 3  line-data ))

            return-type
            class-name
            access
            namespace
            scope 

            ) 
        (cond
         ((string= tag-type "f")
          ;;  check in type field
          ;;("kk"  "/home/jim/ac-php/phptest/a.php:19"  "function kk(){"  "f"  ("namespace". "xxx" )  "return_type" )
       ;;get  return type

          (setq return-type  (nth  5 line-data ))
          (unless return-type 
            (setq return-type  (if (string-match
                                    (concat ".*::[ \t]*\\("ac-php-word-re-str "\\).*")  doc)
                                   (ac-php-clean-namespace-name (match-string 1  doc  ) )
                                 "")))

          (setq scope (nth 4   line-data ))
          (when (and  (car scope   )
                      (string= "namespace" (car scope) )
                      )
            (setq  tag-name   (concat (cdr scope ) "\\" tag-name) ))



          (push   (list  tag-type  (concat tag-name "(" ) (ac-php-gen-el-func doc)  file-pos   (ac-php--clean-return-type return-type) ) function-list  ))
         ((string= tag-type "d")

          ;;("kk"  "/home/jim/ac-php/phptest/a.php:19"  nil  "d"  ("namespace". "xxx" )   "return_type" )
          (setq scope (nth 4   line-data ))

          (if   scope   
              (progn ;class
                (setq class-name  (cdr scope) )
                (setq doc  tag-name )
                (setq access (nth 5 line-data) )
                (setq return-type (nth 6 line-data))
                
                (when (not (assoc-string class-name class-list t ))
                  (push (list class-name nil ) class-list))

                (push (list tag-type tag-name doc file-pos (ac-php--clean-return-type  return-type)  class-name   access ) (cadr (assoc-string  class-name class-list t ) ) )
                )
            (push   (list  tag-type  tag-name tag-name  file-pos  ) function-list  )))
         ((or (string= tag-type "c") (string= tag-type "i"))  ;;class or  interface

          ;;("Testb"  "/home/jim/ac-php/phptest/testb.php:5"  nil  "c" ("namespace"."Test") "Testa" )
          (setq scope (nth 4   line-data ))

          (when (and  (car scope   )
                      (string= "namespace" (car scope) )
                      )
            (setq  tag-name   (concat (cdr scope ) "\\" tag-name) )
            )

          (push   (list  tag-type  tag-name (concat tag-name  ) file-pos  tag-name  ) function-list  )
          ;;add class info 
          (when (not (assoc-string tag-name class-list t ))
            (push (list tag-name nil ) class-list)
            )

          (when (string= tag-type "c")  
            (push  (list tag-name file-pos)   add-class-list))


          ;; add class-inherits
          (let ((p-class-name (nth 5 line-data ) ) )
            (when  p-class-name 
              (push  (list  tag-name  p-class-name ) inherit-list))) )

         ((or (string= tag-type "p")  (string= tag-type "m") ) ;;class function member
          ;; ("v8"  "/home/jim/ac-php/phptest/testb.php:9"  nil  "p" ("class"."Test\\Testb") "public"  "\\Test\\Testa" )
          ;;(setq return-type  )
          (setq return-type (nth 6 line-data))

          (setq class-name (cdr (nth  4 line-data  )))
          (setq access (nth 5  line-data))
          

          ;;add class info 
          (when (not (assoc-string class-name class-list t ))
            (push (list class-name nil ) class-list)
            )
          ;;add member & function 

          (if (string= tag-type "p")
              (setq doc "")
            (setq doc (ac-php-gen-el-func  doc)))

          ;;push TAG item into list 
          (push (list tag-type tag-name doc file-pos (ac-php--clean-return-type  return-type) class-name   access ) (cadr (assoc-string  class-name class-list  t) ) )) 

         )))

    (message "tags-list deal end and reset inherit-list ... ")
    ;;reset inherit-list
    (setq  inherit-list (mapcar (lambda (inherit-item )
                                  (let (
                                        (class-name (nth 0 inherit-item))
                                        (parent-name (nth 1 inherit-item)) cur-namespace check-classname )
                                    (if (s-index-of "\\" parent-name )
                                        inherit-item
                                      (progn
                                        (setq cur-namespace (ac-php--get-namespace-from-classname class-name))
                                        ;;check class in namespace
                                        (setq check-classname (concat cur-namespace "\\" parent-name ) )
                                        (when (assoc-string check-classname class-list t )
                                          (setq parent-name  check-classname))
                                        (list class-name parent-name )
                                        ))
                                    )) inherit-list  ))

    (message "==reset inherit-list  class count=%d ... " (length add-class-list ) )
    ;; gen class __construct
    (dolist (cur-class-item add-class-list)
      (let ( member-info (cur-class (nth 0  cur-class-item ) ) (file-pos (nth 1 cur-class-item) ) )

        (setq member-info (ac-php-get-class-member-info
                           class-list '() cur-class
                           (concat (replace-regexp-in-string ".*\\\\" ""  cur-class  ) "(" ) ))

        (unless member-info
          (setq member-info (ac-php-get-class-member-info class-list inherit-list cur-class  "__construct(" )))
        (if member-info
            ;;(push   (list  "f"  (concat tag-name "(") (concat tag-name  "()" ) file-pos  tag-name  ) function-list  )
            (push   (list  "c"  (concat  cur-class  "(")
                           (nth 2  member-info)
                           (nth 3  member-info) 
                           cur-class 
                           ) function-list  )
          (push   (list  "c"  (concat  cur-class  "(")
                         "" 
                         file-pos
                         cur-class 
                         ) function-list  )
            )
      ))

    (message "  reset inherit-list  end  "  )
    
    ;;reset return type
    (list class-list function-list inherit-list )))

(defun  ac-php-gen-el-func (  doc)
  " example doc 'xxx($x1,$x2)' => $x1 , $x2  "
  (let ( func-str ) 
    (if (string-match "[^(]*(\\(.*\\))[^)]*" doc)
        (progn
          (setq func-str (s-trim (match-string 1 doc) ) )
          (setq func-str (replace-regexp-in-string "[\t ]*,[\t ]*" "," func-str  ) )
          (setq func-str (replace-regexp-in-string "[\t ]+" " " func-str  ) )
          )
      ""
      )))

(defun ac-php--get-tags-save-dir(work-dir  )
  (let ((config (ac-php--get-config work-dir))  tags-save-to-home-dir-flag  ret )
    (when config
      (setq tags-save-to-home-dir-flag (cdr (assoc-string "tags-save-to-home-dir" config))  )
      )

    (setq ret (if  tags-save-to-home-dir-flag
            (concat (getenv "HOME") "/.ac-php/tags"
                    (replace-regexp-in-string "[/ ]" "-" work-dir)  ) 
            (concat work-dir "/.tags" )
        ))
    (mkdir ret t)
    (f-full ret )
    ))


(defun ac-php-get-tags-file (&optional is-lib )
  (let ((tags-dir (ac-php-get-tags-dir)) )
    (if tags-dir
        (concat  (ac-php--get-tags-save-dir tags-dir)  "/tags-data" (if is-lib "-lib" "" ) ".el"  )
      nil)))

(defun ac-php--get-config-path-noti-str ( work-dir path-str)
  (if  (s-ends-with? "*.php" path-str )
      (format "php-path-list-without-subdir->%s" (f-relative (f-parent path-str) work-dir) )
    (format "php-path-list->%s" (f-relative path-str work-dir ))))
(defun ac-php-get-php-files-from-filter(  work-dir filter-info  )
  (let (  conf-list   filter-path-list filter-length filter-index  filter-item  ret-list  also-find-subdir config-file-name   ext-list ext-re-str )
    (when  filter-info
      (progn
        ;;get ext list
        (setq ext-list   (cdr (assoc-string "php-file-ext-list" filter-info)) )
        (unless ext-list (setq ext-list '["php" "inc"]))
        (setq ext-re-str
              (s-concat  "^[^#]+\\.\\("
                         (s-join "\\|"
                                 (mapcar
                                  (lambda(ext) (s-concat "\\(" ext "\\)"   )  )
                                  ext-list ) ) "\\)$" ))
        
        (setq  filter-path-list  (append filter-path-list (mapcar (lambda (path-str) (f-join  work-dir   path-str) )
                                                                  (cdr (assoc-string "php-path-list"  filter-info))
                                                                  )))

        (setq  filter-path-list  (append filter-path-list (mapcar (lambda (path-str)  (f-join work-dir  path-str "*.php" )  )
                                                                  (cdr (assoc-string "php-path-list-without-subdir" filter-info))
                                                                  )))
        ;;sort
        (setq filter-path-list ( sort filter-path-list  'string<))


        ;;check contains
        (let (tmp-union-list check-error-flag) 
          (dolist ( filter-item-name filter-path-list )
            (setq check-error-flag nil)
            (when  (not
                    (or (f-same?   work-dir filter-item-name )
                        (s-starts-with?   work-dir filter-item-name ) )
                    )
              (progn
                (setq check-error-flag t)
                (message "CONFIG FILTER WARRING : [%s] [%s] most in work-dir [%s] "
                         filter-item-name (ac-php--get-config-path-noti-str work-dir filter-item-name )
                         work-dir )))

            (unless check-error-flag 
              (dolist (tmp-item tmp-union-list)
                (when (s-starts-with?  tmp-item filter-item-name )
                  (progn
                    (setq check-error-flag t)
                    (message "CONFIG FILTER WARRING : [%s] in [%s] "
                             (ac-php--get-config-path-noti-str work-dir filter-item-name )
                             (ac-php--get-config-path-noti-str work-dir tmp-item ))
                    ))))

            (unless check-error-flag
              (push filter-item-name tmp-union-list )))

          (setq filter-path-list  tmp-union-list))

        (dolist ( filter-item-name filter-path-list )
          (let (opt-dir also-find-subdir)
            (if (s-ends-with? "*.php" filter-item-name)
                (progn
                  (setq opt-dir (f-parent  filter-item-name ) )
                  (setq also-find-subdir nil))
              (progn
                (setq opt-dir filter-item-name  )
                (setq also-find-subdir t  ))
              )

            (setq ret-list (append ret-list (ac-php-find-php-files opt-dir ext-re-str also-find-subdir ) ) )

            ))
        )
      )
    (ac-php--debug  "++++:%S" ret-list)
    ret-list
    ))

(defun ac-php--get-config ( work-dir )
  (let ( config-file-name )
    
    (setq config-file-name (f-join work-dir ".ac-php-conf.json"  ) )
    (unless (f-exists?  config-file-name )
      (let ((old-config-value json-encoding-pretty-print) )
        (setq  json-encoding-pretty-print  t)
        (f-write-text  (json-encode '(
                                      :tags-save-to-home-dir-flag nil 
                                      :filter
                                      (
                                       :php-file-ext-list
                                       ("php" "inc")
                                       :php-path-list (".")
                                       :php-path-list-without-subdir [] 
                                       )
                                      :lib-filter
                                      (
                                       :php-file-ext-list
                                       ("php" "inc")
                                       :php-path-list [] 
                                       :php-path-list-without-subdir [] 
                                       )

                                      )
                                    ) 'utf-8 config-file-name)
        (setq  json-encoding-pretty-print  old-config-value)
        ))

    (json-read-file  config-file-name  ) 

    ))

(defun ac-php--get-php-files-from-config (work-dir  )
  (let ( conf-list   filter-path-list filter-length filter-index  filter-item  ret-list  also-find-subdir config-file-name  filter-info  lib-filter-info ext-list ext-re-str)
    
    
    (setq conf-list  (ac-php--get-config work-dir) )

    (setq filter-info  (cdr (assoc-string "filter" conf-list )) )
    (setq lib-filter-info  (cdr (assoc-string "lib-filter" conf-list )) )
    (setq ret-list (ac-php-get-php-files-from-filter work-dir lib-filter-info  ) )
    ;;处理
    (let (( filter-list  (ac-php-get-php-files-from-filter work-dir filter-info  )) )
      (ac-php--debug "filter-list :%S" filter-list)
      (dolist (item filter-list)
        (unless (assoc-string (car item ) ret-list  )
          (push (list ( nth 0 item )  ( nth 1 item ) "self") ret-list )
          )))

    ;;(ac-php--debug "===ret-list :%S" ret-list)
    (list ret-list  (cdr (assoc-string "tags-save-to-home-dir" conf-list ))  )
    ))


(defun ac-php-remake-tags (  )
  " reset tags , if  php source  is changed  "
  (interactive)
  (ac-php--remake-tags "self" nil  )
)

(defun ac-php-remake-tags-with-lib (  )
  " reset tags , if  php source  is changed  "
  (interactive)
  (when (ac-php--remake-tags "lib" nil )
    (ac-php--remake-tags "self" nil ))
)

(defun ac-php-remake-tags-all (  )
  "  remake tags without check modify time "
  (interactive)
  (ac-php--remake-tags  "self" t )
)


(defun ac-php--remake-tags ( file-type check-time-flag )
  " reset tags , if  php source  is changed
      opt-flag-value: 0:self , 1:  self + lib , 2 :all remake "
  (let ((tags-dir (ac-php-get-tags-dir) ) tags-dir-len file-list  obj-tags-dir file-name obj-file-name cur-obj-list src-time   obj-item cmd  el-data last-phpctags-errmsg obj-tags-list from-type  cur-file-item tags-save-to-home-dir-flag  ret lib-deal-ret)  
    (message "[%s]do remake %s" file-type tags-dir )
    ;;check lib  is ok

    (if (not ac-php-executable ) (message "no find cmd:  phpctags  please  reinstall ac-php  "   ) )
    (if (not tags-dir) (message "no find .tags dir in path list :%s " (file-name-directory (buffer-file-name)  )   ) )
    (when (and tags-dir  ac-php-executable )

      (setq tags-dir-len (length tags-dir) )

      (let ((tmp  (ac-php--get-php-files-from-config tags-dir  )   ))
        (setq  file-list (nth 0 tmp) )
        (setq tags-save-to-home-dir-flag (nth 1 tmp))
        )

      (setq  obj-tags-dir  (concat ( ac-php--get-tags-save-dir  tags-dir ) "/tags_dir_" (getenv "USER") "/"))
      (if (not (file-directory-p obj-tags-dir ))
          (mkdir obj-tags-dir t))
      (setq obj-tags-list (ac-php-find-php-files obj-tags-dir  "\\.el$" t ))


      (setq cur-file-item (assoc-string (buffer-file-name)  file-list t ))  ;; 

      (setq lib-deal-ret t)
      (when (string=  file-type "self" )
        (when (or ( not (ac-php-get-tags-data t ) ) ;;not find lib
                  check-time-flag ;; need all rebuild 
                  (and cur-file-item  (not (nth 2  cur-file-item ) ) ) ;;cur-file-item is lib : (nth 2  cur-file-item ) = nil
                  )

          (setq lib-deal-ret (ac-php--remake-tags  "lib" check-time-flag ) )
          ))

      (when lib-deal-ret  
        (dolist (file-item file-list )

          (setq from-type  (nth 2 file-item ) )
          (unless from-type (setq  from-type "lib")   )

          (when ( string= from-type file-type )
            
            (setq  file-name (nth  0 file-item )  )
            (setq src-time  (nth 1 file-item ) )
            (setq obj-file-name   (substring file-name  tags-dir-len   ) )
            (setq obj-file-name (replace-regexp-in-string "[/ ]" "-" obj-file-name ))
            (setq obj-file-name (replace-regexp-in-string "\\.[a-zA-Z0-9_]+$" ".el" obj-file-name ))
            (setq  obj-file-name (f-full (concat obj-tags-dir  obj-file-name )))

            (push obj-file-name cur-obj-list )
            ;;check change time
            (ac-php--debug "obj-file-name %s " obj-file-name  )
            (setq obj-item (assoc-string obj-file-name obj-tags-list t ))

            (when (or (not obj-item) (< (nth 1 obj-item) src-time )  check-time-flag )
              ;;gen tags file
              (message "rebuild %s " file-name )
              (let ( cmd cmd-output   )
                (setq cmd (concat ac-php-executable  " -f \"" obj-file-name "\" \""   file-name "\""  ) )
                (ac-php--debug "exec cmd:%s" cmd)
                (setq cmd-output (shell-command-to-string  cmd) )
                
                (when (> (length cmd-output) 3)
                  (princ (concat "phpctags ERROR:" cmd-output ))
                  (delete-file  obj-file-name  )
                  (setq last-phpctags-errmsg (format "phpctags[%s] ERROR:%s " file-name cmd-output  ))))
              ;;gen el data file
              )))

        (unless last-phpctags-errmsg
          ;;read data
          (let ((temp-list cur-obj-list) tags-list )
            (with-temp-buffer
              (message "[%s]BUILD marge files (count=%d ) start..." file-type (length cur-obj-list) )
              (insert "(")
              (while temp-list  

                (goto-char (point-max) )
                (insert-file-contents (car   temp-list ))
                (setq temp-list (cdr  temp-list)))

              (goto-char (point-max) )
              (insert ")")

              (goto-char (point-min) )
              (setq  tags-list (read (current-buffer))))

            (message "[%s]BUILD marge files end  and then start deal ..." file-type)
            (ac-php-save-data  (ac-php-get-tags-file (string= file-type  "lib") )  (ac-php-gen-data  tags-list tags-dir-len  file-type  )))
          ;;( (ac-php-get-tags-file ) (ac-php-gen-data  tags-lines tags-dir-len)  )


          ;;  TODO do cscope  
          (when (and ac-php-cscope  ac-php-use-cscope-flag )
            (message "[%s]rebuild cscope  data file " file-type )
            ;;write cscope.files
            (let ((file-name-list ) cscope-file-name )
              (dolist (file-item file-list )
                (setq cscope-file-name (concat "../" (substring (nth  0 file-item ) tags-dir-len)  ))
                (push  cscope-file-name   file-name-list ))
              (f-write
               (s-join  "\n" file-name-list )
               'utf-8
               (concat tags-dir ".tags/cscope.files" ) ))
            (shell-command-to-string
             (concat " cd " tags-dir ".tags &&  cscope -bkq -i cscope.files  ") ) )

          )

        (if last-phpctags-errmsg
            (princ last-phpctags-errmsg )
          (message "[%s]BUILD SUCCESS." file-type)
          (setq ret t)
          ) 
        ))
    ret
    ))


(defun ac-php-save-data (file data)
  (message "save to  %s ..." file)
  ;;(f-write  (format "%S" data ) 'utf-8  file)
  (with-temp-file file
    (let ((standard-output (current-buffer))
          (print-circle t) ; Allow circular data
          )  
      (prin1 data)))
  )

(defun ac-php-load-data (file)
  (let  ((file-attr   (file-attributes  file ) ) file-data  conf-last-time  file-last-time  )
    (when file-attr
      (setq file-last-time (+  (*(nth 0 (nth 5 file-attr) )  65536)  (nth 1 (nth 5 file-attr)) ))
      (setq  conf-last-time (nth  1 (assoc-string file  ac-php-tag-last-data-list   ) ) )
        
      (when (or (null conf-last-time) (> file-last-time conf-last-time ))
        (with-temp-buffer
          (insert-file-contents file)
          (setq  file-data  (read (current-buffer))))
        (assq-delete-all  file   ac-php-tag-last-data-list )
        (push (list file file-last-time  file-data ) ac-php-tag-last-data-list  )))
    (nth  2 (assoc-string file  ac-php-tag-last-data-list   ))))


(defun ac-php-get-tags-data (&optional is-lib )
  (let ((tags-file   (ac-php-get-tags-file is-lib )))
    (if tags-file
        (ac-php-load-data  tags-file  )
      ac-php-comm-tags-data-list ))) 

;;; ==============END

(defun ac-php-get-tags-dir  ()
  "DOCSTRING"
  (let (tags-dir tags-file) 
    (when (buffer-file-name) 
      (setq tags-dir (file-name-directory (buffer-file-name)  ))
    )

    (unless tags-dir
      (setq tags-dir ( expand-file-name  default-directory) ))

    (while (not (or (file-exists-p  (concat tags-dir  ".tags" )) (string= tags-dir "/") ))
      (setq tags-dir  ( file-name-directory (directory-file-name  tags-dir ) ) ))
    (if (string= tags-dir "/") (setq tags-dir nil )   )
    tags-dir
    ))
(defun ac-php--get-check-class-list ( class-name inherit-list )
  "DOCSTRING"
  (let ((tmp-class class-name )
        (check-class-list (list  (ac-php-clean-namespace-name class-name)))
          )

    (while (and (setq  tmp-class (nth 1 (assoc-string (ac-php-clean-namespace-name tmp-class) inherit-list  t  )))
                (not (assoc-string   tmp-class check-class-list )))

      (push  (ac-php-clean-namespace-name (nth 0 (s-split "," tmp-class)) ) check-class-list )
      )
    (nreverse check-class-list )
    ))

(defun ac-php--get-item-info (member )
    "DOCSTRING"
  (let (type-str ) 
    (if (and (> (length member ) 1)  (string=  "(" ( substring  member  -1 )) )
        (progn
          (setq member (substring member 0 -1 ) )
          (setq type-str "m"))
      (setq type-str "p")) 
    (list member type-str )
    ))


(defun ac-php-get-class-member-info (class-list inherit-list  class-name member )
  "DOCSTRING"
  (let ((check-class-list ) (ret ) find-flag  type-str tmp-ret tag-type )
    (setq check-class-list  (ac-php--get-check-class-list class-name inherit-list ) )
    
    (setq tmp-ret (ac-php--get-item-info member ) )
    (setq member (nth 0 tmp-ret))
    (setq type-str (nth 1 tmp-ret))

    (let (  class-member-list )
      (dolist (opt-class check-class-list)
        (setq  class-member-list  (nth 1 (assoc-string opt-class class-list  t ))) 
        ;;(ac-php--debug "member %s class=%s, %S" member opt-class  class-member-list )
        (dolist (member-info class-member-list)
          (when(ac-php--string=-ignore-care (nth 1 member-info ) member    )
            (setq tag-type (nth 0 member-info)  )
            (ac-php--debug "tag-type=%s type-str=%s member-info  %S " tag-type type-str    member-info )
            (when (or  ( string= tag-type  "d" )
                       (string= tag-type  type-str ))
              (setq ret  (copy-tree member-info ))
              (when (string= "S" (nth 3 ret ))
                  (setf (nth 3 ret ) (format "system:class.%s:%s"  opt-class member)   ) 
                  )
              
              (setq find-flag t)
              (return))))
        (if find-flag (return) )
        ))
    (ac-php--debug "ac-php-get-class-member-info  ret=%S" ret)
    ret))


(defun ac-php-get-class-member-list (class-list inherit-list  class-name  )
  "DOCSTRING"
  (setq  class-name (ac-php-clean-namespace-name  class-name) )
  (let ( (check-class-list ) (ret ) find-flag  )
    (setq check-class-list  (ac-php--get-check-class-list class-name inherit-list ) )
    (ac-php--debug "check-class-list %S" check-class-list)

    (let (  class-member-list tmp-data  )
      (dolist (opt-class check-class-list)
        (setq tmp-data (assoc-string  opt-class class-list  t ) )
        (setq  class-member-list  (copy-tree (nth 1 tmp-data )))  ;;copy-tree : will not change tags-data

        (if ret 
            (nconc ret class-member-list)
          (setq ret class-member-list  ) )
        ))
    ret
    ))


(defun ac-php-get-class-name-by-key-list( tags-data key-list-str )
  (let (temp-class (cur-class "" ) (class-list (nth 0 tags-data) ) (inherit-list (nth 2 tags-data)) (key-list (split-string key-list-str "\\." ) ) )
    (dolist (item key-list )
      (if (string= cur-class "" )
          (if (or (assoc-string item inherit-list  t ) (assoc-string  item class-list t )  )
              (setq cur-class item)
            (return))
        (progn
          (setq temp-class cur-class)

          (if (string= item "__parent__" )
              (progn
                (setq cur-class (nth 1 (assoc-string cur-class inherit-list  t ))  ) 
                (if (not cur-class) (setq cur-class "") ))
            (let ( member-info)
              (setq member-info (ac-php-get-class-member-info class-list inherit-list cur-class  item ))
              (setq cur-class (if  member-info
                                  (let (tmp-class cur-namespace check-classname member-local-class-name)
                                    (setq tmp-class (nth 4 member-info) )
                                    (ac-php--debug "tmp-class %s member-info:%S" tmp-class member-info )
                                    (when (stringp tmp-class )
                                      (if (s-index-of "\\" tmp-class )
                                          tmp-class
                                        (progn
                                          (setq member-local-class-name (nth 5 member-info) )
                                          (setq cur-namespace (ac-php--get-namespace-from-classname member-local-class-name ))
                                          (setq check-classname (concat cur-namespace "\\" tmp-class  ) )
                                          (if (assoc-string check-classname class-list t )
                                              check-classname tmp-class )))) )
                                ""))

              ))

          (when (string= cur-class "")
              (message (concat " class[" temp-class "]'s member[" item "] not define type "))
            (return))

          ))
      )
    cur-class
    ))
(defun ac-php--get-namespace-from-classname (classname)
  (ac-php-clean-namespace-name (nth 1 (s-match  "\\(.*\\)\\\\[a-zA-Z0-9_]+$" classname ) ) ))

(defun ac-php-find-symbol-at-point-pri ()
  (let ( key-str-list  line-txt cur-word val-name class-name output-vec    jump-pos  cmd complete-cmd  find-flag tags-data ret)
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position )))
    (setq cur-word  (ac-php--get-cur-word-with-function-flag ))
    (ac-php--debug "key-str-list==begin:cur-word:%s" cur-word )
    (setq key-str-list (ac-php-get-class-at-point  ))

    (ac-php--debug "key-str-list==end:%s" key-str-list)

    (setq  tags-data  (ac-php-get-tags-data )  )
    (if  key-str-list  
        (progn
          (if tags-data
              (progn
                (let (class-name member-info  )  
                  ;;(setq key-str-list (replace-regexp-in-string "\\.[^.]*$" (concat "." cur-word ) key-str-list ))
                  (when (string= cur-word "")
                    (let ((key-arr (s-split "\\." key-str-list  ) ) )
                      (ac-php--debug "key-arr %S " key-arr)
                      (setq cur-word (nth (1- (length key-arr)) key-arr ))))

                  (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list ))
                  (setq class-name (ac-php-get-class-name-by-key-list  tags-data key-str-list ))

                  (ac-php--debug "class.member= %s.%s " class-name  cur-word )
                  ;;(message "class %s" class-name)
                  (if (not (string= class-name "" ) )
                      (progn 
                        (setq member-info (ac-php-get-class-member-info (nth 0 tags-data)  (nth 2 tags-data)  class-name cur-word ) )
                        (if member-info
                            (setq ret (list "class_member"  (concat (ac-php-get-tags-dir)  (nth 3 member-info)  )      (nth 4 member-info) member-info )  )
                          (progn
                            (message "no find %s.%s " class-name cur-word  )
                            )
                          ))
                    ;;(message "no find class  from key-list %s " key-str-list  )
                    )
                  )))
          )

      (progn ;;function
        (if tags-data 
            (progn
              (let ((function-list (nth 1 tags-data ))  (class-list (nth 0 tags-data ) ) full-name tmp-ret file-pos  )

                (when (string= "" cur-word) ;;new
                  (setq tmp-ret  ( ac-php-get-syntax-backward (concat "new[ \t]+\\(" ac-php-word-re-str "\\)") 1 ))
                  (when tmp-ret (setq cur-word (ac-php-clean-namespace-name  tmp-ret )))
                  )
                ;;check "namespace" "use as"  
                (setq full-name (ac-php--get-class-full-name-in-cur-buffer
                                 cur-word 
                                 function-list  nil ) )

                (when full-name  (setq  cur-word  full-name) )

                ;;TODO FIX namespace function like Test\ff()
                (ac-php--debug "check user function===%s" cur-word )
                (when (string=  cur-word "self"  ) 
                  (setq cur-word (concat (ac-php-get-cur-class-name)  ) )
                  )

                (dolist (function-item function-list )
                  (when (ac-php--string=-ignore-care (nth 1 function-item )  cur-word  )
                    (setq file-pos (nth 3 function-item ) )
                    
                    (when (string= "S" file-pos )
                      (if (string= "c" (nth 0 function-item ))
                          (setf file-pos  (format "system:class.%s"     (nth 1 function-item ) ) ) 
                        (setf file-pos  (format "system:function.%s"     (nth 1 function-item ) ) ) 
                          )
                      )
                    (setq ret (list "user_function"  (concat (ac-php-get-tags-dir)  file-pos   )      (nth 4 function-item) function-item  ) )
                    
                    (setq find-flag t)
                    (return )))
                )
              ))

        ))

    (ac-php--debug  "ac-php-find-symbol-at-point-pri :%S "  ret ) 
    ret
    ))

(defun ac-php--goto-local-var-def ( local-var )
  "goto local-var like vim - gd" 
  (let ( )
    (ac-php-location-stack-push)
    (beginning-of-defun)
    (re-search-forward (concat "\\" local-var "\\b"  ) ) ; => \\$var\\b
    (ac-php-location-stack-push)
    ))

(defun ac-php-find-symbol-at-point (&optional prefix)
  (interactive "P")
  ;;检查是类还是 符号 
  (let ((symbol-ret (ac-php-find-symbol-at-point-pri)) type jump-pos tmp-arr local-var  local-var-flag )
    (setq local-var (ac-php-get-cur-word-with-dollar ) )
    (setq local-var-flag  (s-matches-p "^\\$"  local-var)  )

    
    
    (if symbol-ret
        (progn 
          (setq type (car symbol-ret ))
          (if   (and (not (string= type "class_member") ) local-var-flag  )
              ( ac-php--goto-local-var-def local-var  )
            (cond
             ((or (string= type "class_member")  (string= type "user_function") )
              
              (setq tmp-arr  (s-split ":" (nth 1 symbol-ret) ) )
              (cond
               ((s-matches-p "system$" (nth 0 tmp-arr) )
                (progn ;;system function
                  (php-search-documentation (nth 0 (ac-php--get-item-info (nth 1 tmp-arr) )))
                  ))
               (t
                (progn 
                  (setq jump-pos  (nth 1  symbol-ret ) )
                  (ac-php-location-stack-push)
                  (ac-php-goto-location jump-pos )
                  (ac-php-location-stack-push)
                  )
                ))
              ) 
             )))
      (when local-var-flag ( ac-php--goto-local-var-def local-var  ) )
      )
    ))


(defun ac-php-gen-def ()
  "DOCSTRING"
  (interactive)
  (let (line-txt (cur-word  (ac-php-get-cur-word ) ) )
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position )))
    (if  (string-match ( concat  "$" cur-word ) line-txt)
        (let ((class-name "<...>" ) )
          (when (string-match (concat  cur-word"[\t ]*=.*[(;]" ) line-txt)
            ;;call function
            (let (key-str-list  pos) 
              (save-excursion
                (re-search-forward "[;]")
                (re-search-backward "[^ \t]")
                (setq pos (point) )
                )

              (when pos (setq key-str-list (ac-php-get-class-at-point pos ) ))

              (if  key-str-list ;;class-name
                  (setq class-name (ac-php-get-class-name-by-key-list  (ac-php-get-tags-data) key-str-list ))
                (progn ;;function TODO

                  ))))

          (kill-new (concat "\n\t/**  @var  $" cur-word " " class-name "  */\n") ))
      (kill-new (concat "\n\t/**  @var  $" cur-word "  " cur-word "*/\n") ))))

(defun ac-php-location-stack-forward ()
  (interactive)
  (ac-php-location-stack-jump -1))

(defun ac-php-location-stack-back ()
  (interactive)
  (ac-php-location-stack-jump 1))



(defun ac-php-location-stack-jump (by)
  (interactive)
  (let ((instack (nth ac-php-location-stack-index ac-php-location-stack))
        (cur (ac-php-current-location)))
    (if (not (string= instack cur))
        (ac-php-goto-location instack )
      (let ((target (+ ac-php-location-stack-index by)))
        (when (and (>= target 0) (< target (length ac-php-location-stack)))
          (setq ac-php-location-stack-index target)
          (ac-php-goto-location (nth ac-php-location-stack-index ac-php-location-stack) ))))))



(defun ac-php-candidate ()
  (let ( key-str-list  tags-data)
    (setq key-str-list (ac-php-get-class-at-point))
    (ac-php--debug "GET key-str-list  :%s" key-str-list)
    (setq  tags-data  (ac-php-get-tags-data )  )
    (if key-str-list
        (ac-php-candidate-class tags-data key-str-list  )
      (ac-php-candidate-other tags-data))
    ))
(defun ac-php-get-cur-word ( )
  (let (start-pos cur-word)
	(save-excursion
	  (skip-chars-backward "a-z0-9A-Z_\\\\")
	  (setq start-pos (point))
	  (skip-chars-forward "a-z0-9A-Z_\\\\")
      (ac-php-clean-namespace-name (buffer-substring-no-properties start-pos (point)))
	  )
    )) 
(defun ac-php-get-cur-word-with-dollar ( )
  (let (start-pos cur-word)
	(save-excursion
	  (skip-chars-backward "\\$a-z0-9A-Z_")
	  (setq start-pos (point))
	  (skip-chars-forward "\\$a-z0-9A-Z_")
      (ac-php-clean-namespace-name (buffer-substring-no-properties start-pos (point)))
	  )
    )) 

(defun ac-php--get-cur-word-with-function-flag ( )
  (let (start-pos cur-word)
	(save-excursion
      (ac-php--debug "ac-php--get-cur-word-with-function-flag:%S" (point)  )
	  (skip-chars-backward "a-z0-9A-Z_\\\\")
	  (setq start-pos (point))
	  (skip-chars-forward "a-z0-9A-Z_\\\\")
	  (skip-chars-forward " \t")
	  (skip-chars-forward "(")
      (s-replace-all '((" "."" )  ("\t"."" ))   (ac-php-clean-namespace-name (buffer-substring-no-properties start-pos (point))))
	  )
    )) 

(defun ac-php-get-cur-word-without-clean ( )
  (let (start-pos cur-word)
	(save-excursion
	  (skip-chars-backward "a-z0-9A-Z_\\\\")
	  (setq start-pos (point))
	  (skip-chars-forward "a-z0-9A-Z_\\\\")
	  )
      (buffer-substring-no-properties start-pos (point))
    )) 

(defun ac-php-show-tip(&optional prefix)
  (interactive "P")
  ;;检查是类还是 符号 
  (let ((symbol-ret (ac-php-find-symbol-at-point-pri)) type  doc class-name access return-type member-info tag-name function-item file-pos )
    (when symbol-ret
      (setq type (car symbol-ret ))
      (setq member-info (nth 3 symbol-ret))
      (cond
       ((string= type "class_member")

        (setq tag-name  (nth 1 member-info ))
        (if ( string= (nth 0 member-info )  "m" )
            (setq  doc   (concat  tag-name  "(" (nth 2 member-info) ")" )   )
          (setq  doc    tag-name ))

        (setq  class-name   (nth 5 member-info) )
        (setq  return-type   (nth 4 member-info) )
        (setq  access   (nth 6 member-info) )
        (popup-tip (concat  (ac-php-clean-document doc)  "\n\t[  type]:"  return-type  "\n\t[access]:" access  "\n\t[  from]:"   (nth 5 member-info)   ))

        )
       ((string= type "user_function") 
        (setq function-item (nth 3 symbol-ret))
        (setq tag-name  (nth 1 function-item ))
        (if ( ac-php--tag-name-is-function   tag-name )
            (setq  doc   (concat  tag-name  (nth 2 function-item) ")" )   )
          (setq  doc   (nth 2 function-item) ))

        (setq file-pos (nth 3 function-item ) )

        (setq  return-type (nth 4 function-item ) )
        (popup-tip (concat "[" (if (string= "S" file-pos ) "system" "  user" )  "]:"  (ac-php-clean-document doc) "\n[  type]:"  return-type   ))
       
        )) )))




(defvar ac-php-template-start-point nil)
(defvar ac-php-template-candidates (list "ok" "no" "yes:)"))

(defun ac-php-action ()
  (interactive)
  ;; (ac-last-quick-help)
  (let (
        (cur-item (cdr ac-last-completion) )
        (help )
        (raw-help )

        (tag-type )
        (candidates (list)) ss fn args (ret-t "") ret-f)

    (setq help (ac-php-clean-document (get-text-property 0 'ac-php-help cur-item )))
    (setq raw-help (get-text-property 0 'ac-php-help cur-item ))
    (setq tag-type (get-text-property 0 'ac-php-tag-type cur-item) )

    (if  (ac-php--tag-name-is-function cur-item )
        (setq raw-help (concat  cur-item raw-help ")"  ) )
      )
    (ac-php--debug "raw-help:%s " raw-help)

    (dolist (item (split-string raw-help "\n"))
      ;;do_f($v1,$v2 =0,$v3 =0)
      (if (s-matches-p ( concat"^" ac-php-word-re-str "(" )  item )
          (let (match-ret args-list)
            (setq match-ret (s-match
                             (concat "^\\(" ac-php-word-re-str  "\\)(\\(.*\\))$"  )
                             item  ))

            (if match-ret
                (let ((option-start-index 1000000 ) (i 0) find-flag
                      (item-pre-str (concat (nth 1  match-ret) "(") ) )
                  (setq args-list (s-split  ","  (nth 2  match-ret ))  )
                  (dolist (arg args-list   )
                    (when (and  (not find-flag) (s-matches-p "=" arg ) )
                      (setq find-flag t)
                      (setq option-start-index i )
                      )
                    (setf (nth i args-list) ( replace-regexp-in-string "=.*" "" arg ))
                    (setq i (1+ i ) ))

                  (ac-php--debug "ac-php-action option-start-index =%d" option-start-index )
                  (setq i 0)
                  (dolist (arg args-list   )
                    (when (>= i  option-start-index )
                      (push (propertize  (concat item-pre-str ")"  ) 'ac-php-help item ) ss))
                    (setq  item-pre-str (concat item-pre-str (if (= i 0) "" "," )  arg  ) )
                    (setq i (1+ i )))
                  (push  (propertize  (concat item-pre-str ")" ) 'ac-php-help item  ) ss))

              (push item ss)))
        (push item ss)))


      

    (ac-php--debug "SS=%S raw-help=%s"  ss  raw-help )
    (dolist (s ss)
      ;;return type
      (cond ((string-match "^\\([^(]*\\)(\\(.*)\\)" s)
             (ac-php--debug "do function")
             (setq fn (match-string 1 s)
                   args (match-string 2 s))
             (push (propertize (ac-php-clean-document args) 'ac-php-help (get-text-property 0 'ac-php-help s)  
                               'raw-args args) candidates)
             ))) 

    (ac-php--debug "ac-php-action candidates=%S " candidates)
    (cond (candidates
           (setq candidates (delete-dups candidates))
           (setq candidates (nreverse candidates))
           (setq ac-php-template-candidates candidates)
           (setq ac-php-template-start-point (point))
           (ac-complete-php-template)

           (unless (cdr candidates) ;; unless length > 1
             (message (replace-regexp-in-string "\n" "   ;    " help))))
          (t
           (message (replace-regexp-in-string "\n" "   ;    " help)))
          )))

(defun ac-php-cscope-find-egrep-pattern (symbol)
  "auto set  cscope-initial-directory and  Run egrep over the cscope database."
  (interactive (list
                (let (cscope-no-mouse-prompts)
                  (cscope-prompt-for-symbol "Find this egrep pattern " nil t t))
                ))

  (if ac-php-use-cscope-flag
      (progn
        (setq cscope-initial-directory  (ac-php--get-tags-save-dir (ac-php-get-tags-dir) )  )
        (cscope-find-egrep-pattern symbol)
        )
    (message "need  config: (setq ac-php-use-cscope-flag t)  ")
    )
  )

(defun ac-php-template-candidate ()
  ac-php-template-candidates)

(defun ac-php-template-action ()
  (interactive)
  (unless (null ac-php-template-start-point)
    (let ((pos (point)) sl (snp "")
          (s (get-text-property 0 'raw-args (cdr ac-last-completion))))

      ;;remove & in args  "&$item,$v" => "$item,$v"
      (setq s (s-replace "&" "" s ) )

      (cond ((featurep 'yasnippet)
             (setq s (concat "${" s))
             (setq s (replace-regexp-in-string ")" "})" s))
             (setq s (replace-regexp-in-string "," "},${" s))
             
             (when (string= "${})" s) (setq s ")"))

             (condition-case nil
                 (yas-expand-snippet s ac-php-template-start-point pos) ;; 0.6.1c
               (error
                ;; try this one:
                (ignore-errors (yas-expand-snippet ac-php-template-start-point pos s)) ;; work in 0.5.7
                )))

            (t
             (message "Dude! You are too out! Please install a yasnippet or a snippet script:)"))))))


(defun ac-php-template-prefix ()
  ac-php-template-start-point)


(defun ac-php-prefix ()
  (or (ac-prefix-symbol)
      (let ((c (char-before)) ret )
        (when (or
               ;; ->
               (and (eq ?> c) (eq ?- (char-before (1- (point)))))
               ;; :: 
               (and (eq ?: c) (eq ?: (char-before (1- (point))))))

          (setq  ret (point)))
        (unless ret
          (save-excursion
            (skip-chars-backward "a-z0-9A-Z_\\\\")
            (setq ret (point))
            )
          )
        ret
        )))

(when (featurep 'auto-complete) 
  
  (eval  '(ac-define-source php
    '((candidates . ac-php-candidate)
      (candidate-face . ac-php-candidate-face)
      (selection-face . ac-php-selection-face)
      (prefix . ac-php-prefix)
      (requires . 0)
      (document . ac-php-document)
      (action . ac-php-action)
      (cache)
      (symbol . "p"))) )


 (eval  '(ac-define-source php-template
    '((candidates . ac-php-template-candidate)
      (prefix . ac-php-template-prefix)
      (requires . 0)
      (action .  ac-php-template-action)
      (document . ac-php-template-document )
      (cache)
      (symbol . "t")))))
