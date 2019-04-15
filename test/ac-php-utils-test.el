;;; ac-php-utils-test.el --- Utils tests -*- lexical-binding: t; -*-

;; Copyright (C) 2014-2019 jim <xcwenn@qq.com>
;; Copyright (C) 2019 Serghei Iakovlev <sadhooklay@gmail.com>

;; Author: jim <xcwenn@qq.com>
;; Maintainer: jim
;; URL: https://github.com/xcwen/ac-php

;; This file is not part of GNU Emacs.

;;; License

;; This file is free software; you can redistribute it and/or
;; modify it under the terms of the GNU General Public License
;; as published by the Free Software Foundation; either version 3
;; of the License, or (at your option) any later version.

;; This file is distributed in the hope that it will be useful,
;; but WITHOUT ANY WARRANTY; without even the implied warranty of
;; MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
;; GNU General Public License for more details.

;; You should have received a copy of the GNU General Public License
;; along with this file; if not, write to the Free Software
;; Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
;; 02110-1301, USA.

;;; Commentary:

;; Automate tests from the "test" directory using `ert', which comes bundled
;; with Emacs >= 24.1.

;;; Code:

(ert-deftest ac-php-search/in-function-std-case ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "<?php
function foo () {

}"
   (goto-char (point-max))
   (should (eq (ac-php--in-function-p) nil))
   (should (eq (ac-php--in-function-p (1- (point))) t))
   (should (eq (ac-php--in-function-p 1) nil))
   (should (eq (ac-php--in-function-p 24) t))
   (goto-char (point-min))
   (should (eq (ac-php--in-function-p 24) t))))

(provide 'ac-php-utils-test)
;;; ac-php-utils-test.el ends here
