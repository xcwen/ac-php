;;; ac-php.el --- auto-completion source for php

;; Copyright (C) 2014 - 2016 jim

;; Author: xcwenn@qq.com [https://github.com/xcwen]
;; URL: https://github.com/xcwen/ac-php
;; Keywords: completion, convenience, intellisense
;; Package-Requires: ((ac-php-core "1") (auto-complete "1.4.0") (yasnippet "0.8.0")  )



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
;; support  Linux and OSX,  but windows need more test
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
;;      '(("melpa" . "https://melpa.org/packages/")) )
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

(require 'ac-php-core)

(require 'auto-complete)

(defface ac-php-candidate-face
  '((t (:background "lightgray" :foreground "navy")))
  "Face for php candidate"
  :group 'auto-complete)

(defface ac-php-selection-face
  '((t (:background "navy" :foreground "white")))
  "Face for the php selected candidate."
  :group 'auto-complete)


(defun ac-php-prefix ()
  (let ((c (char-before)) ret )
    (when (or
           ;; ->
           (and (eq ?> c) (eq ?- (char-before (1- (point)))))
           ;; ::
           (and (eq ?: c) (eq ?: (char-before (1- (point))))))

      (setq  ret (point)))
    (unless ret
      (save-excursion
        (skip-chars-backward "\\$a-z0-9A-Z_\\\\")
        (setq ret (point))
        )
      )
    ret
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

(defun ac-php-action ()
  (interactive)
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
    (setq ss (reverse ss) )


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


(defvar ac-php-template-start-point nil)
(defvar ac-php-template-candidates (list "ok" "no" "yes:)"))

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

(defun ac-php-template-document (item)
  (if (stringp item)
      (let (doc  tag-type return-type access from-class)
        (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help item)))
        )
  ))

(defun  ac-php-candidate-ac()
  (setq  ac-php-prefix-str  ac-prefix )
  (ac-php-candidate )
    )



(eval  '(ac-define-source php
          '((candidates . ac-php-candidate-ac )
            ;;(candidate-face . ac-php-candidate-face)
            ;;(selection-face . ac-php-selection-face)
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
            (symbol . "t"))))

(provide 'ac-php)
;;; ac-php.el ends here
