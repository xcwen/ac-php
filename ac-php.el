;;; ac-php.el --- Auto Completion source for php for GNU Emacs

;; Copyright (C) 2014  jim 


;; Author: xcwenn@qq.com [https://github.com/xcwen]
;; URL: https://github.com/xcwen/ac-php
;; Keywords: completion, convenience, intellisense
;; Version: 20150226
;; Package-Requires: ((emacs "24") ( php-mode "1") (auto-complete "1.4.0") (yasnippet "0.8.0") (xcscope "1"))



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

;; thanks auto-complete-clang , rtags ( ac-php-location-stack-index )

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


;;load sys-data
(require 'ac-php-sys-data)

(require 'auto-complete)
(require 'php-mode)
(require 'popup)

(defvar ac-php-executable (concat  (file-name-directory load-file-name) "phpctags"))



(defcustom ac-php-cscope 
  (executable-find "cscope")
  "*Location of cscope executable"
  :group 'auto-complete
  :type 'file)




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
          (nbutlast ac-php-location-stack (- (length ac-php-location-stack) ac-php-max-bookmark-count))))))


(defun ac-php-goto-line-col (line column)
  (goto-char (point-min))
  (forward-line (1- line))
  (beginning-of-line)
  (forward-char (1- column)))

(defun ac-php-current-location (&optional offset)
  (format "%s:%d:%d" (or (buffer-file-name) (buffer-name))
          (line-number-at-pos offset) (1+ (- (or offset (point)) (point-at-bol)))))
(defun ac-php--string=-ignore-care( str1 str2  )
  (not (integer-or-marker-p ( compare-strings  str1  0 nil str2  0 nil t ))  )
  )

(defun ac-php-find-file-or-buffer (file-or-buffer &optional other-window)
  (if (file-exists-p file-or-buffer)
      (if other-window
          (find-file-other-window file-or-buffer)
        (find-file file-or-buffer))
    (let ((buf (get-buffer file-or-buffer)))
      (cond ((not buf) (message "No buffer named %s" file-or-buffer))
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
    (ac-php-location-stack-push)
    ))





(defsubst ac-php-clean-document (s)
  (when s
    (setq s (replace-regexp-in-string "<#\\|#>\\|\\[#" "" s))
    (setq s (replace-regexp-in-string "#\\]" " " s)))
  s)

(defun ac-php-document (item)
  (if (stringp item)
      (let (doc  tag-type return-type access)
        (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help item)))
        (setq tag-type (get-text-property 0 'ac-php-tag-type item))
        (setq return-type (get-text-property 0 'ac-php-return-type item))
        (setq access (get-text-property 0 'ac-php-access item))
        (cond
         ( (or (string= tag-type "p") ( string= tag-type "m") )
          (format "%s\n\t[  type]:%s\n\t[access]:%s" doc  return-type access   ) )
         (return-type 
          (format "%s  %s " return-type doc   ) )
         (t
          doc))
        ))
  )


(defface ac-php-candidate-face
  '((t (:background "lightgray" :foreground "navy")))
  "Face for php candidate"
  :group 'auto-complete)

(defface ac-php-selection-face
  '((t (:background "navy" :foreground "white")))
  "Face for the php selected candidate."
  :group 'auto-complete)

(defun ac-php-check-not-in-string-or-comment (pos)
  "ac-php-check-in-string-or-comment"
  (if  (nth 8 (syntax-ppss pos))  nil  t )
  ) 
(defun ac-php-check-not-in-comment (pos)
  "ac-php-check-in-string-or-comment"
  (if  (nth 4 (syntax-ppss pos))  nil  t )
  ) 


(defun ac-php-get-syntax-backward ( re-str  pos  &optional  in-comment-flag  )
  "DOCSTRING"
  (let (line-txt ret-str find-pos need-find-flag )  
    (setq need-find-flag t )
    (save-excursion
      (while  need-find-flag
        (if (re-search-backward  re-str  0 t 1)
            (progn
              (when (if in-comment-flag
                        (not (ac-php-check-not-in-comment (point) ) )
                      (ac-php-check-not-in-string-or-comment (point))) 
                (setq line-txt (buffer-substring-no-properties (line-beginning-position) (line-end-position)))
                (when (string-match   re-str    line-txt)
                  (setq  ret-str  (match-string pos line-txt))
                  (setq need-find-flag nil))))
          (setq need-find-flag nil)
          )
        )
      )
    ret-str ))



(defun ac-php-get-cur-class-name ()
  "DOCSTRING"
  ( ac-php-get-syntax-backward "^[ \t]*\\(abstract[ \t]+\\)*class[ \t]+\\(\\w+\\)" 2 ))
(defun ac-php-clean-namespace-name (namespace-name)
    (if (and namespace-name  ( string=  (substring-no-properties  namespace-name 0 1  ) "\\" ) )
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
  "DOCSTRING"
  ( ac-php-get-syntax-backward  (concat "^[ \t]*namespace[ \t]+\\(" ac-php-word-re-str "\\)")  1  ))



(defun ac-php-get-class-at-point( &optional pos  )

  (let (line-txt old-line-txt  key-line-txt  key-list   tmp-key-list frist-class-name  frist-key  ret-str )
    ;; default use cur point 
    (unless  pos (setq pos (point) ))

    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (1+ pos ) ))
    (setq old-line-txt line-txt)
    
    (setq line-txt (replace-regexp-in-string "\\<return\\>\\|\\<echo\\>" "" line-txt  ))
    (setq line-txt (replace-regexp-in-string ".*[=(,.]" "" line-txt  ))
    (setq line-txt (replace-regexp-in-string "^[^a-zA-Z\\\\]*" "" line-txt  ))
    (setq line-txt (replace-regexp-in-string "[\t $]" "" line-txt  ))
    (when (not (string=  line-txt "")  )
      ;;检查 :: 
      (if (and (string-match  "::"  line-txt ) (not (string-match  "\\/\\*"  line-txt ) ))
          (progn 
            (setq key-list (split-string line-txt "::" ))
            (setq frist-key (nth 0 key-list))
            (setq frist-key (ac-php-clean-namespace-name frist-key) )
            (setq frist-class-name  frist-key  )
            (cond
             ((string= frist-key "parent" ) 
              (setq frist-class-name (concat (ac-php-get-cur-full-class-name) ".__parent__" ) ))
             ((string= frist-key "self" ) 
              (setq frist-class-name (concat (ac-php-get-cur-full-class-name) ) ))
             ((string-match  "\$[a-zA-Z0-9_]*[\t ]*::" old-line-txt  )  (setq frist-class-name nil))

             ))

        (progn
          (setq key-list (split-string line-txt "->" ))
          (setq frist-key (nth 0 key-list))
          (setq frist-key (ac-php-clean-namespace-name frist-key) )

          ;;check for new define   @var $v  class_type 
          (setq frist-class-name  (ac-php-clean-namespace-name (ac-php-get-syntax-backward  (concat "@var[\t ]+"  "$" frist-key "[\t ]+\\(" ac-php-word-re-str "\\)" )  1   t )))

          ;;check for old define  $v:: class_type 
          (unless frist-class-name 
            (setq  frist-class-name
                   (ac-php-clean-namespace-name (ac-php-get-syntax-backward  (concat "$" frist-key "[\t ]*::[\t ]*\\(" ac-php-word-re-str "\\)" )  1   t )))
            )


          (when (and(not frist-class-name) (or (string= frist-key "this")  ) ) 
            (setq frist-class-name (ac-php-get-cur-full-class-name)  ))
          )))

    
    (if frist-class-name 
        (progn
          (setq ret-str  (concat frist-class-name ))
          (dolist (field-value (cdr key-list) )
            (setq ret-str  (concat  ret-str "." field-value )))
          ret-str
          )
      ;;(message "no find class from %s" frist-key )
      nil)))

(defun ac-php-candidate-class ( tags-data key-str-list  )
  ;;得到变量
  (let ( ret-list key-word output-list  class-name  (class-list (nth 0 tags-data)) (inherit-list (nth 2 tags-data))  )
    (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list ))
    (setq class-name (ac-php-get-class-name-by-key-list  tags-data key-str-list ))

    (progn

      (setq  output-list (ac-php-get-class-member-list  class-list inherit-list  class-name ) )
      (mapc (lambda (x)
                (setq key-word (nth 1 x ))
                (setq key-word (propertize key-word 'ac-php-help  (nth 2  x ) ))
                (setq key-word (propertize key-word 'ac-php-return-type (nth 4  x ) ))
                (setq key-word (propertize key-word 'ac-php-tag-type (nth 0  x ) ))
                (setq key-word (propertize key-word 'ac-php-access (nth 6  x ) ))
                (setq key-word (propertize key-word 'summary  (nth 0  x )    ))
                (push key-word ret-list  )
                nil
                ) output-list )
      )
    ret-list))

(defun ac-php-candidate-other ( tags-data)
  
  (let (ret-list (ac-prefix-len (length ac-prefix)) cmp-value )
    ;;系统函数
    (dolist  (key-word ac-php-sys-function-list)

      (when (>= (length key-word) ac-prefix-len)
        (setq cmp-value   (substring-no-properties  key-word 0 ac-prefix-len ) )
        (if (string<   ac-prefix  cmp-value) (return ))
        (if (string= cmp-value  ac-prefix ) (push key-word ret-list  ))
        ))
    ;;用户函数

    (if tags-data 
        (let ((function-list (nth 1 tags-data )  ) key-word )

          (dolist (function-item function-list )
            (when (string-prefix-p  ac-prefix (nth 1 function-item )  )
              (setq key-word (nth  1 function-item ))
              (setq key-word (propertize key-word 'ac-php-help  (nth 2  function-item ) ))
              (setq key-word (propertize key-word 'ac-php-return-type   (nth 4  function-item ) ))
              (push key-word ret-list  )
              )))
      )
    


    ret-list
    ))
;;; ==============BEGIN
(defun ac-php-find-php-files ( work-dir regex )
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
        (setq sub-results  (ac-php-find-php-files file-name regex ) )

        (if results
            (nconc results sub-results)
          (setq results sub-results))
        ))
    results 
    ))

(defun ac-php-gen-data ( tags-lines project-dir-len )
  "gen-el-data"
  (let ( class-list function-list inherit-list (file-start-pos project-dir-len ) (count 0 ) )
    (dolist (line-data tags-lines)
      (when (and
             (> (length line-data ) 0)
             (not (string= (substring line-data 0 1 ) "!" ) )
             (string-match "^\\(\\w+\\)\t\\(.*\\)\t/\\^\\(.+\\)\\$/;\"\t\\(\\w\\)\tline:\\([0-9]+\\)\\(.*\\)" line-data)
             )


        (let (
              (tag-name (match-string 1  line-data ))
              (file-pos (concat (substring  (match-string 2  line-data )  file-start-pos ) ":" (match-string 5  line-data )   ))
              (doc (match-string 3  line-data ))
              (tag-type (match-string 4  line-data ))
              other-data

              return-type
              class-name
              access

              ) 
          (cond
           ((string= tag-type "f")
            ;;  check in type field
            (setq other-data  (match-string 6  line-data ) )
            (when (string-match  (concat  ".*\ttype:\\(" ac-php-word-re-str "\\).*" ) other-data)
              (setq return-type  (match-string 1  other-data  )))

            (push   (list  tag-type  tag-name (ac-php-gen-el-func tag-name doc)  file-pos  return-type ) function-list  ))
           ((string= tag-type "d")


            (setq other-data  (match-string 6  line-data ) )


            (if (string-match (concat "^\tclass:\\(" ac-php-word-re-str "\\)") other-data)
                (progn ;class
                (setq class-name (match-string 1  other-data  ))
                (setq doc  tag-name )
                (setq return-type "" )
                (setq access "public" )

                (when (not (assoc-string class-name class-list t ))
                  (push (list class-name nil ) class-list))

                (push (list tag-type tag-name doc file-pos return-type  class-name   access ) (cadr (assoc-string  class-name class-list t ) ) )
                )
              (push   (list  tag-type  tag-name tag-name  file-pos  ) function-list  ))

            )
           ((or (string= tag-type "c") (string= tag-type "i"))  ;;class or  interface

            (setq other-data  (match-string 6  line-data ) )
            (when (string-match (concat ".*\tnamespace:\\(" ac-php-word-re-str "\\)\\(,.*\\)*") other-data)
              (setq  tag-name   (concat (match-string 1  other-data ) "\\" tag-name) )
              )

            (push   (list  tag-type  tag-name (concat tag-name  "()" ) file-pos  ) function-list  )
            ;; add class-inherits
            (when (string-match  (concat  ".*\tinherits:\\(" ac-php-word-re-str "\\)\\(,.*\\)*" ) other-data)
              (push  (list  tag-name   (match-string 1  other-data  )) inherit-list)))

           ((or (string= tag-type "p")  (string= tag-type "m") ) ;;class function member
            (setq other-data  (match-string 6  line-data ) )

            ;;get  return type
            (setq return-type  (if (string-match (concat ".*::[ \t]*\\("ac-php-word-re-str "\\).*")  doc)
                                   (ac-php-clean-namespace-name (match-string 1  doc  ) )
                                 ""))

            ;;  check in type field
            (when  (string= return-type "" )
              (when (string-match  (concat  ".*\ttype:\\(" ac-php-word-re-str "\\).*" ) other-data)
                (setq return-type  (match-string 1  other-data  ))))


            (when (string-match (concat "^\t\\(class\\|interface\\):\\(" ac-php-word-re-str "\\)\taccess:\\(\\w+\\)") other-data)
              (setq class-name (match-string 2  other-data  ))
              (setq access (match-string 3  other-data  ))
              )
            ;;add class info 
            (when (not (assoc-string class-name class-list t ))
              (push (list class-name nil ) class-list))
            ;;add member & function 

            (if (string= tag-type "p")
                (setq doc tag-name)
              (setq doc (ac-php-gen-el-func tag-name doc) ))

            ;;push TAG item into list 
            (push (list tag-type tag-name doc file-pos return-type class-name   access ) (cadr (assoc-string  class-name class-list  t) ) ))

           ))))
    (list class-list function-list inherit-list )))

(defun  ac-php-gen-el-func ( func-name doc)
  "DOCSTRING"
  (let ( func-str ) 
    (if (string-match ".*(\\(.*\\)).*" doc)
        (progn
          (setq func-str (replace-regexp-in-string "," "#>,<#" (match-string 1 doc) ) )
          (setq func-str (replace-regexp-in-string "[\t ]+" "" func-str  ) )
          (concat func-name "(<#" func-str "#>)" )
          )
      (concat func-name "()")
      )))
(defun ac-php-get-tags-file ()
  ""
  (let ((tags-dir (ac-php-get-tags-dir)) )
    (if tags-dir
        (concat   tags-dir ".tags/tags-data.el"  )
      nil)))

(defun ac-php-remake-tags ()
  " reset tags , if  php source  is changed  "
  (interactive)
  (let ((tags-dir (ac-php-get-tags-dir) ) tags-dir-len file-list  obj-tags-dir file-name obj-file-name cur-obj-list src-time   obj-item cmd  el-data last-phpctags-errmsg obj-tags-list)  

    (message "remake %s" tags-dir )
    (if (not ac-php-executable ) (message "no find cmd:  phpctags,  put it in /usr/bin/  and restart emacs "   ) )
    (if (not tags-dir) (message "no find .tags dir in path list :%s " (file-name-directory (buffer-file-name)  )   ) )
    (when (and tags-dir  ac-php-executable )
      (setq tags-dir-len (length tags-dir) )
      (setq obj-tags-dir (concat tags-dir ".tags/tags_dir_" (getenv "USER") "/" ))
      (if (not (file-directory-p obj-tags-dir ))
          (mkdir obj-tags-dir))
      (setq file-list (ac-php-find-php-files tags-dir "^[^#]+\\.php$" ) )
      (setq obj-tags-list (ac-php-find-php-files obj-tags-dir  "\\.tags$" ) )
      
      (dolist (file-item file-list )

        (setq  file-name (nth  0 file-item )  )
        (setq src-time  (nth 1 file-item ) )
        (setq obj-file-name   (substring file-name  tags-dir-len   ) )
        (setq obj-file-name (replace-regexp-in-string "/" "-" obj-file-name ))
        (setq obj-file-name (replace-regexp-in-string "\\.php$" ".tags" obj-file-name ))
        (setq  obj-file-name (concat obj-tags-dir  obj-file-name ))

        (push obj-file-name cur-obj-list )
        ;;check change time
        (setq obj-item (assoc-string obj-file-name obj-tags-list t ))
        (when (or (not obj-item) (< (nth 1 obj-item) src-time ) )
          ;;gen tags file
          (message "rebuild %s" file-name )
          (let (cmd-output   )
            (setq cmd-output (shell-command-to-string (concat ac-php-executable  " -f " obj-file-name " "  file-name  )) )
            
            (when (> (length cmd-output) 3)
              (princ (concat "phpctags ERROR:" cmd-output ))
              (delete-file  obj-file-name  )
              (setq last-phpctags-errmsg (format "phpctags[%s] ERROR:%s " file-name cmd-output  ))))
          ;;gen el data file
          ))
      ;;加入参数
      (let ((temp-list cur-obj-list) tags-lines )
        (setq cmd "cat" )
        (while temp-list  
          (setq  cmd (concat cmd  " " (car  temp-list  )  ))
          (setq temp-list (cdr  temp-list)))

        ;;(message "%s" cmd)
        (setq tags-lines  (split-string (shell-command-to-string  cmd ) "\n"   ))
        (ac-php-save-data  (ac-php-get-tags-file ) (ac-php-gen-data  tags-lines tags-dir-len)  )
        ;;  TODO do cscope  
        (when ac-php-cscope
          (message "rebuild cscope  data file " )
          (setq tags-lines  (split-string (shell-command-to-string  cmd ) "\n"   ))
          (shell-command-to-string  (concat " cd " tags-dir ".tags &&  find  ../ -name \"[A-Za-z0-9_]*.php\" ! -path \"../.tags/*\"  > cscope.files &&  cscope -bkq -i cscope.files  ") ) )
        (if last-phpctags-errmsg
            (princ last-phpctags-errmsg )
          (message "BUILD SUCCESS.")
          ) 
        ))))

(defun ac-php-save-data (file data)
  (with-temp-file file
    (let ((standard-output (current-buffer))
          (print-circle t))  ; Allow circular data
      (prin1 data))))

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


(defun ac-php-get-tags-data ()
  (let ((tags-file   (ac-php-get-tags-file )))
    (if tags-file
        (ac-php-load-data  tags-file  )
      nil))) 

;;; ==============END

(defun ac-php-get-tags-dir  ()
  "DOCSTRING"
  (let (tags-dir tags-file) 
    (setq tags-dir (file-name-directory (buffer-file-name)  ))
    (while (not (or (file-exists-p  (concat tags-dir  ".tags" )) (string= tags-dir "/") ))
      (setq tags-dir  ( file-name-directory (directory-file-name  tags-dir ) ) ))
    (if (string= tags-dir "/") (setq tags-dir nil )   )
    tags-dir
    ))


(defun ac-php-get-class-member-info (class-list inherit-list  class-name member )
  "DOCSTRING"
  (let ((tmp-class class-name ) (check-class-list (list  (ac-php-clean-namespace-name class-name))) (ret ) find-flag )
    (while (setq  tmp-class (nth 1 (assoc-string (ac-php-clean-namespace-name tmp-class) inherit-list  t  )) )
      (push  (ac-php-clean-namespace-name tmp-class) check-class-list )
      )
    (setq check-class-list (nreverse check-class-list ) )
    (let (  class-member-list )
      (dolist (opt-class check-class-list)
        (setq  class-member-list  (nth 1 (assoc-string opt-class class-list  t ))) 
        (dolist (member-info class-member-list)
          (when (ac-php--string=-ignore-care (nth 1 member-info ) member    )
            (setq ret  member-info)
            (setq find-flag t)
            (return)))
        (if find-flag (return) )
        ))
    ret))


(defun ac-php-get-class-member-list (class-list inherit-list  class-name  )
  "DOCSTRING"
  (setq  class-name (ac-php-clean-namespace-name  class-name) )
  (let ((tmp-class class-name ) (check-class-list (list class-name)) (ret ) find-flag )
    (while (setq  tmp-class (nth 1 (assoc-string tmp-class inherit-list  t)) )
      (push tmp-class check-class-list )
      )
    (setq check-class-list (nreverse check-class-list ) )
    (let (  class-member-list )
      (dolist (opt-class check-class-list)
        (setq  class-member-list  (copy-tree (nth 1 (assoc-string  opt-class class-list  t ))))  ;;copy-tree : will not change tags-data
        (if ret 
            (nconc ret class-member-list)
          (setq ret class-member-list  ) )
        ))
    ret
    ))


(defun ac-php-get-class-name-by-key-list-pri ( tags-data key-list-str )
  (let (temp-class (cur-class "" ) (class-list (nth 0 tags-data) ) (inherit-list (nth 2 tags-data)) (key-list (split-string key-list-str "\\." ) ) )
    (dolist (item key-list )
      (if (string= cur-class "" )
          (setq cur-class item)
        (progn
          (setq temp-class cur-class)

          (if (string= item "__parent__" )
              (progn
                (setq cur-class (nth 1 (assoc-string cur-class inherit-list  t ))  ) 
                (if (not cur-class) (setq cur-class "") ))
            (let ( member-info)
              (setq member-info (ac-php-get-class-member-info class-list inherit-list cur-class  item ))
              (setq cur-class (if  member-info
                                  (nth 4 member-info)
                                ""))

              ))

          (when (string= cur-class "")
            (message (concat " class[" temp-class "]'s member[" item "] not define type "))
            (return))

          ))
      )
    cur-class
    ))

(defun ac-php-get-class-name-by-key-list ( tags-data key-list-str )
  "DOCSTRING"
  (let ( class-name  frist-key  ( key-list (split-string key-list-str "\\." ) ) )
    (setq frist-key (nth 0 key-list))
    (setq class-name "")
    (if (not ( string-match "\\\\" frist-key) ) ;no find namespace fix
        (let (full-key-list-str namespace-name)
          (setq namespace-name (ac-php-get-cur-namespace-name))
          (when namespace-name 
            (setq full-key-list-str (concat namespace-name "\\" key-list-str) )
            (setq class-name (ac-php-get-class-name-by-key-list-pri  tags-data full-key-list-str   ) ))

          (when (string= class-name "" )
            (setq class-name (ac-php-get-class-name-by-key-list-pri  tags-data key-list-str   ) )
            )
          class-name)
        (ac-php-get-class-name-by-key-list-pri  tags-data key-list-str  )
      )
    )) 

(defun ac-php-find-symbol-at-point (&optional prefix)
  (interactive "P")
  ;;检查是类还是 符号 
  (let ( key-str-list  line-txt cur-word val-name class-name output-vec    jump-pos  cmd complete-cmd  find-flag tags-data)
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position )))
    (setq cur-word  (ac-php-get-cur-word ))
    (setq key-str-list (ac-php-get-class-at-point ))

    (setq  tags-data  (ac-php-get-tags-data )  )
    (if  key-str-list  
        (progn
          (if tags-data
              (progn
                (let (class-name member-info  )  
                  ;;(setq key-str-list (replace-regexp-in-string "\\.[^.]*$" (concat "." cur-word ) key-str-list ))
                  (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list ))
                  (setq class-name (ac-php-get-class-name-by-key-list  tags-data key-str-list ))
                  ;;(message "class %s" class-name)
                  (if (not (string= class-name "" ) )
                      (progn 
                        (setq member-info (ac-php-get-class-member-info (nth 0 tags-data)  (nth 2 tags-data)  class-name cur-word ) )
                        (if member-info
                            (progn
                              (setq jump-pos  (concat (ac-php-get-tags-dir)  (nth 3 member-info)  ))
                              (ac-php-location-stack-push)
                              (ac-php-goto-location jump-pos ))
                          (message "no find %s.%s " class-name cur-word  )
                          ))
                    ;;(message "no find class  from key-list %s " key-str-list  )
                    )
                  ))))

      (progn ;;function
        (if tags-data 
            (progn
              (let ((function-list (nth 1 tags-data )  ))

                (dolist (function-item function-list )
                  (when (ac-php--string=-ignore-care (nth 1 function-item )  cur-word  )
                    (setq jump-pos  (concat (ac-php-get-tags-dir)  (nth 3 function-item)   ))
                    (ac-php-location-stack-push)
                    (ac-php-goto-location jump-pos )
                    (setq find-flag t)
                    (return )))
                )
              ))

        (if (not find-flag )
            (progn
              
              (dolist (function-str ac-php-sys-function-list )
                (when (ac-php--string=-ignore-care    function-str cur-word)
                ;;(unless (integer-or-marker-p ( compare-strings  function-str 0 nil cur-word 0 nil t ))
                  (php-search-documentation cur-word  )
                  (return )))

              ))))
	))

(defun ac-php-gen-def ()
  "DOCSTRING"
  (interactive)
  (let (line-txt (cur-word  (ac-php-get-cur-word ) ) )
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position )))
    (message "11111111")
    (if  (string-match ( concat  "$" cur-word ) line-txt)
        (let ((class-name "<...>" ) )
          (when (string-match (concat  cur-word"[\t ]*=[\t ]*new[\t ]+\\("  ac-php-word-re-str "\\)" ) line-txt)
            (setq class-name (match-string 1 line-txt)))
          (when (string-match (concat  cur-word"[\t ]*=.*[(;]" ) line-txt)
            ;;call function
            (let (key-str-list  pos) 
              (save-excursion
                (re-search-forward "[(;]")
                (re-search-backward "[^ \t]")
                (setq pos (1- (point)) )
                )
              (when pos (setq key-str-list (ac-php-get-class-at-point pos ) ))

              (if  key-str-list ;;class-name
                  (setq class-name (ac-php-get-class-name-by-key-list  (ac-php-get-tags-data) key-str-list ))
                (progn ;;function TODO

                  ))))

          (kill-new (concat "\n\t/**  @var  $" cur-word " " class-name "  */\n") ))
      (kill-new (concat "\n\t/** \n\t *\n\t * @var  " cur-word "\n\t */\n\tpublic   $" cur-word ";\n") ))))

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

(defun ac-php-show-tip	(&optional prefix)
  (interactive "P")
  (let ( key-str-list  line-txt cur-word val-name class-name output-vec    class-name return-type access doc  cmd complete-cmd  find-flag tags-data )
    (setq line-txt (buffer-substring-no-properties
                    (line-beginning-position)
                    (line-end-position )))
    (setq cur-word  (ac-php-get-cur-word ))

    (setq  tags-data  (ac-php-get-tags-data )  )
    (setq key-str-list (ac-php-get-class-at-point ))
    (if  key-str-list  
        (progn
          (if tags-data
              (progn
                (let (class-name member-info  )  
                  (setq key-str-list (replace-regexp-in-string "\\.[^.]*$" "" key-str-list ))
                  (setq class-name (ac-php-get-class-name-by-key-list  tags-data key-str-list ))
                  (setq member-info (ac-php-get-class-member-info (nth 0 tags-data)    (nth 2 tags-data)  class-name cur-word ) )
                  (if member-info
                      (progn
                        (setq  doc   (nth 2 member-info) )
                        (setq  class-name   (nth 5 member-info) )
                        (setq  return-type   (nth 4 member-info) )
                        (setq  access   (nth 6 member-info) )
                        (popup-tip (concat class-name  "::"  (ac-php-clean-document doc)  "\n\t[  type]:"  return-type  "\n\t[access]:" access     ))
                        )
                    )
                  ))))


      (progn ;;function
        (if tags-data 
            (progn
              (let ((function-list (nth 1 tags-data ) ))

                (dolist (function-item function-list )
                  (when (string=  (nth 1 function-item )  cur-word)
                    (setq  doc   (nth 2 function-item ) )
                    (popup-tip (concat "[user]:"  (ac-php-clean-document doc)  ))
                    (setq find-flag t)
                    (return )))
                ))) 

        (if (not find-flag) 
            (let ((cur-function (php-get-pattern) ) function-info) ;;sys function
              (dolist (function-str ac-php-sys-function-list )
                (when (string= function-str cur-function)
                  (setq function-info (get-text-property 0 'ac-php-help  function-str ) )
                  (popup-tip (concat "[system]:" (ac-php-clean-document function-info)))
                  (return )))
              
              ))))
    ))



(defvar ac-php-template-start-point nil)
(defvar ac-php-template-candidates (list "ok" "no" "yes:)"))

(defun ac-php-action ()
  (interactive)
  ;; (ac-last-quick-help)
  (let ((help (ac-php-clean-document (get-text-property 0 'ac-php-help (cdr ac-last-completion))))
        (raw-help (get-text-property 0 'ac-php-help (cdr ac-last-completion)))
        (candidates (list)) ss fn args (ret-t "") ret-f)
    (setq ss (split-string raw-help "\n"))
    (dolist (s ss)
      (when (string-match "\\[#\\(.*\\)#\\]" s)
        (setq ret-t (match-string 1 s)))
      (setq s (replace-regexp-in-string "\\[#.*?#\\]" "" s))
      (cond ((string-match "^\\([^(]*\\)\\((.*)\\)" s)
             (setq fn (match-string 1 s)
                   args (match-string 2 s))
             (push (propertize (ac-php-clean-document args) 'ac-php-help ret-t
                               'raw-args args) candidates)
             (when (string-match "\{#" args)
               (setq args (replace-regexp-in-string "\{#.*#\}" "" args))
               (push (propertize (ac-php-clean-document args) 'ac-php-help ret-t
                                 'raw-args args) candidates))
             (when (string-match ", \\.\\.\\." args)
               (setq args (replace-regexp-in-string ", \\.\\.\\." "" args))
               (push (propertize (ac-php-clean-document args) 'ac-php-help ret-t
                                 'raw-args args) candidates)))
            ((string-match "^\\([^(]*\\)(\\*)\\((.*)\\)" ret-t) ;; check whether it is a function ptr
             (setq ret-f (match-string 1 ret-t)
                   args (match-string 2 ret-t))
             (push (propertize args 'ac-php-help ret-f 'raw-args "") candidates)
             (when (string-match ", \\.\\.\\." args)
               (setq args (replace-regexp-in-string ", \\.\\.\\." "" args))
               (push (propertize args 'ac-php-help ret-f 'raw-args "") candidates)))))
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
  (setq cscope-initial-directory  (concat (ac-php-get-tags-dir) ".tags" )  )
  (cscope-find-egrep-pattern symbol)
  )

(defun ac-php-template-candidate ()
  ac-php-template-candidates)

(defun ac-php-template-action ()
  (interactive)
  (unless (null ac-php-template-start-point)
    (let ((pos (point)) sl (snp "")
          (s (get-text-property 0 'raw-args (cdr ac-last-completion))))
      (cond ((string= s "")
             ;; function ptr call
             (setq s (cdr ac-last-completion))
             (setq s (replace-regexp-in-string "^(\\|)$" "" s))
             (setq sl (ac-clang-split-args s))
             (cond ((featurep 'yasnippet)
                    (dolist (arg sl)
                      (setq snp (concat snp ", ${" arg "}")))
                    (condition-case nil
                        (yas-expand-snippet (concat "("  (substring snp 2) ")")
                                            ac-php-template-start-point pos) ;; 0.6.1c
                      (error
                       ;; try this one:
                       (ignore-errors (yas-expand-snippet
                                       ac-php-template-start-point pos
                                       (concat "("  (substring snp 2) ")"))) ;; work in 0.5.7
                       )))
                   (t
                    (message "Dude! You are too out! Please install a yasnippet or a snippet script:)"))))
             (t
             (unless (string= s "()")
               (setq s (replace-regexp-in-string "{#" "" s))
               (setq s (replace-regexp-in-string "#}" "" s))
               (cond ((featurep 'yasnippet)
                      (setq s (replace-regexp-in-string "<#" "${" s))
                      (setq s (replace-regexp-in-string "#>" "}" s))
                      (setq s (replace-regexp-in-string ", \\.\\.\\." "}, ${..." s))
                      (condition-case nil
                          (yas-expand-snippet s ac-php-template-start-point pos) ;; 0.6.1c
                        (error
                         ;; try this one:
                         (ignore-errors (yas-expand-snippet ac-php-template-start-point pos s)) ;; work in 0.5.7
                         )))

                     (t
                      (message "Dude! You are too out! Please install a yasnippet or a snippet script:)")))))))))


(defun ac-php-template-prefix ()
  ac-php-template-start-point)


(defun ac-php-prefix ()
  (or (ac-prefix-symbol)
      (let ((c (char-before)))
        (when (or
               ;; ->
               (and (eq ?> c) (eq ?- (char-before (1- (point)))))
               ;; :: 
               (and (eq ?: c) (eq ?: (char-before (1- (point))))))

          (point)))))

(ac-define-source php
  '((candidates . ac-php-candidate)
    (candidate-face . ac-php-candidate-face)
    (selection-face . ac-php-selection-face)
    (prefix . ac-php-prefix)
    (requires . 0)
    (document . ac-php-document)
    (action . ac-php-action)
    (cache)
    (symbol . "p")))


(ac-define-source php-template
  '((candidates . ac-php-template-candidate)
    (prefix . ac-php-template-prefix)
    (requires . 0)
    (action . ac-php-template-action)
    (document . ac-php-document)
    (cache)
    (symbol . "t")))
