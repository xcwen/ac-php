;;; company-php.el --- company  source for php for GNU Emacs
;; Copyright (C) 2014 - 2016 jim 
;; Author: xcwenn@qq.com [https://github.com/xcwen]
;; URL: https://github.com/xcwen/ac-php
;; Keywords: completion, convenience, intellisense
;; Package-Requires: ( (cl-lib "0.5") (ac-php-core "1") (company "1")  )

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
;;  company source for php. 
;; Only support  Linux and OSX , not support Windows
;; More info and **example** at : https://github.com/xcwen/ac-php 

;;(add-hook 'php-mode-hook
;;          '(lambda ()
;;             (require 'company-php)
;;             (company-mode t)
;;             (add-to-list 'company-backends 'company-ac-php-backend )))


;;; Code:

(require 'cl-lib)
(require 'company)
(require 'ac-php-core)



(defun company-ac-php-annotation (item)
  ( let( doc  ) 
    (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help item)))
    (if ( ac-php--tag-name-is-function item) 
        (concat doc ")"   )  
      "")))


(defun company-ac-php-fuzzy-match (prefix candidate)
  (cl-subsetp (string-to-list prefix)
              (string-to-list candidate)))

(defun company-ac-php--prefix ()
  (buffer-substring (point) (save-excursion (skip-chars-backward "a-z0-9A-Z_\\\\" )
                                            (point)))
  )


(defun  company-ac-php-candidate  (arg)
  (let ( raw-help  ac-php-company-list   ac-php-prefix-str-len )
    (setq ac-php-prefix-str (company-ac-php--prefix))
    (setq  ac-php-prefix-str-len  (length ac-php-prefix-str  ) )

    (dolist (  candidate-item (ac-php-candidate) )
      (setq raw-help (get-text-property 0 'ac-php-help candidate-item ))
      (when  (ac-php--string=-ignore-care  ac-php-prefix-str (s-left  ac-php-prefix-str-len candidate-item ))  
        (if (ac-php--tag-name-is-function  candidate-item  )
            (dolist (item (split-string raw-help "\n"))
              (let ( args-list (option-start-index 1000000 ) (i 0) find-flag
                               (item-pre-str "" ) )
                (setq args-list (s-split  ","   item)  )
                (dolist (arg args-list   )
                  (when (and  (not find-flag) (s-matches-p "=" arg ) )
                    (setq find-flag t)
                    (setq option-start-index i )
                    )
                  (setf (nth i args-list) ( replace-regexp-in-string "=.*" "" arg ))
                  (setq i (1+ i ) ))

                (setq i 0)
                (dolist (arg args-list   )
                  (when (>= i  option-start-index )
                    (push (propertize  candidate-item  'ac-php-help  (concat item-pre-str   )  )  ac-php-company-list  ))
                  (setq  item-pre-str (concat item-pre-str (if (= i 0) "" "," )  arg  ) )
                  (setq i (1+ i )))
                (push  (propertize  candidate-item   'ac-php-help  (concat item-pre-str  ) ) ac-php-company-list ))
              )
          (push  candidate-item   ac-php-company-list  )
          ))

      )
    ac-php-company-list
    ))


(defun company-ac-php-backend (command &optional arg &rest ignored)
  (interactive (list 'interactive))

  (case command
    (interactive (company-begin-backend 'company-ac-php-backend))
    (prefix (and (eq major-mode 'php-mode)
                 (company-ac-php--prefix  )
                 )
            )
    (candidates
     (company-ac-php-candidate arg ))
    (annotation (company-ac-php-annotation arg))
    (duplicates t)
    (post-completion (let( (doc)  )
                       (when ( ac-php--tag-name-is-function arg)
                         (setq doc (ac-php-clean-document (get-text-property 0 'ac-php-help arg)))
                         (insert  (concat doc  ")") )
                         (company-template-c-like-templatify (concat arg   doc  ")") )
                         )
                       ;;(setq company-backends  (list 'company-ac-php-args-list-backend) )

                       ;;(company-complete  ;;)
                       ;;(setq  company-backends tmp)
                       ) )
    ;;(no-cache 't)
    ))

(provide 'company-php)

;;; company-php.el ends here
