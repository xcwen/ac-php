;;; ac-php-search-test.el --- Search tests -*- lexical-binding: t; -*-

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

(ert-deftest ac-php-search/classlike-std-class ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Abcde {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Abcde"))))

(ert-deftest ac-php-search/classlike-1st-line ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "<?php class Abcde {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Abcde"))))

(ert-deftest ac-php-search/classlike-final ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "final class AdminLoginJob {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "AdminLoginJob"))))

(ert-deftest ac-php-search/classlike-abstract ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "abstract class Post {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Post"))))

(ert-deftest ac-php-search/classlike-trait ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "trait SharePost {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "SharePost"))))

(ert-deftest ac-php-search/classlike-small-caps ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class abcde {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "abcde"))))

(ert-deftest ac-php-search/classlike-digist-and-symbols ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Swift_SmtpTransport_2 {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Swift_SmtpTransport_2"))))

(ert-deftest ac-php-search/classlike-few-classes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Foo {}
class Bar {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Bar"))))

(ert-deftest ac-php-search/classlike-stress-spaces ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "                   class             Abcde {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Abcde"))))

(ert-deftest ac-php-search/classlike-extended-ascii-codes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Ÿ¼ÿ©¥ {}"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-class-name) "Ÿ¼ÿ©¥"))))

(ert-deftest ac-php-search/classlike-invalid-ascii-code ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class !Ÿ¼ÿ©¥ {}"
   (goto-char (point-max))
   (should-not (string= (ac-php-get-cur-class-name) "!Ÿ¼ÿ©¥"))))

(provide 'ac-php-search-test)
;;; ac-php-search-test.el ends here
