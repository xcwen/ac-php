;;; helm-ac-php-apropros.el --- A helm apropos.  -*- lexical-binding: t; -*-

;; Copyright (C) 2018  Antoine Brand <antoine597@gmail.com>

;; Author: Antoine Brand <antoine597@gmail.com>
;; Maintainer: jim
;; URL: https://github.com/xcwen/ac-php
;; Keywords: convenience, helm
;; Package-Requires: ((ac-php-core "2.0.3") (helm "1"))
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

;; An apropos functionality using the ac-php index and helm as interface.
;;
;; Many options available under Help:Customize
;; Options specific to ac-php are in
;;   Convenience/Completion/Auto Complete
;;
;; Known to work with Linux and macOS.  Windows support is in beta stage.
;; For more info and examples see URL `https://github.com/xcwen/ac-php' .
;;
;; Bugs: Bug tracking is currently handled using the GitHub issue tracker
;; (see URL `https://github.com/xcwen/ac-php/issues')

;;; Code:

(require 'pcase)
(require 'ac-php)
(require 'helm)
(require 'cl-lib)    ; `cl-equalp'

(defun helm-ac-php--init ()
  (with-current-buffer (helm-candidate-buffer 'global)
    (maphash
     (lambda (k v)
       (mapc
        (lambda (v)
          (when (not (cl-equalp "sys" (aref v 3)))
            (insert
             (propertize
              (concat
               (aref v 5) "::"
               (pcase (aref v 0)
                 ("d" (aref v 1))
                 ("m" (substring (aref v 1) 0 (- (string-width (aref v 1)) 1)))
                 ("p" (concat "$" (aref v 1))))
               " "
               (aref v 6))
              'position (aref v 3))
             "\n")))
        v))
     (ac-php-g--class-map (ac-php-get-tags-data)))
    (maphash
     (lambda (k v)
       (when (not (cl-equalp "sys" (aref v 3)))
         (insert
          (propertize
           (pcase (aref v 0)
             ("d" (concat (if (cl-equalp "void" (aref v 4)) "" (aref v 4)) (aref v 1)))
             ("f" (concat (if (cl-equalp "void" (aref v 4)) "" (aref v 4)) (substring (aref v 1) 0 (- (string-width (aref v 1)) 1))))
             ("c" (aref v 1))
             ("i" (aref v 1)))
           'position (aref v 3)))
         (insert "\n")))
     (ac-php-g--function-map (ac-php-get-tags-data)))))

(defun helm-ac-php--action ()
  (let* ((candidate (helm-get-selection nil 'withprop))
         (position (get-text-property 0 'position candidate)))
    (string-match "\\([0-9]+\\):\\([0-9]+\\)" position)
    (let ((file (match-string 1 position))
          (line (match-string 2 position)))
      (find-file (aref (ac-php-g--file-list (ac-php-get-tags-data)) (string-to-number file)))
      (with-no-warnings
        (goto-line (string-to-number line))))))

(defvar helm-ac-php--source
  '((name . "Php apropos")
    (init . helm-ac-php--init)
    (candidates . helm-candidates-in-buffer)
    (volatile)
    (match . identity)
    (multimatch . multi1)
    (filtered-candidate-transformer helm-fuzzy-highlight-matches)
    (get-line . buffer-substring)
    (search helm-mm-exact-search helm-mm-search helm-candidates-in-buffer-search-default-fn)
    (action . helm-ac-php--action)))

;;;###autoload
(defun helm-ac-php-apropos ()
  (interactive)
  (helm :sources 'helm-ac-php--source :buffer "*php apropos*"))

;;;###autoload
(defun helm-ac-php-apropos-at-point ()
  (interactive)
  (helm :sources 'helm-ac-php--source :buffer "*php apropos*" :input (thing-at-point 'symbol)))

(provide 'helm-ac-php-apropros)
;;; helm-ac-php-apropros.el ends here
