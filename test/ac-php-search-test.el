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

;;;; Classlike

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

;;;; Namespace

(ert-deftest ac-php-search/namespace-std-name ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace Acme;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Acme\\"))))

(ert-deftest ac-php-search/namespace-1st-line ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "<?php namespace Acme;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Acme\\"))))

(ert-deftest ac-php-search/namespace-symbols-and-digits ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace PhpParser\\Node_2\\Class_;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name)
                    "\\PhpParser\\Node_2\\Class_\\"))))

(ert-deftest ac-php-search/namespace-leading-backslashes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace \\Acme;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Acme\\"))))

(ert-deftest ac-php-search/namespace-trim-extra-backslashes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace Acme\\Foo\\;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Acme\\Foo\\"))))

(ert-deftest ac-php-search/namespace-trim-trailing-backslashes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace Acme\\Foo\\;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name t) "\\Acme\\Foo"))))

(ert-deftest ac-php-search/namespace-stress-spaces ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "                    namespace              Acme                 ;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Acme\\"))))

(ert-deftest ac-php-search/namespace-extended-ascii-codes ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace Ÿ¼ÿ©¥;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) "\\Ÿ¼ÿ©¥\\"))))

(ert-deftest ac-php-search/namespace-invalid-ascii-code ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "namespace !Ÿ¼ÿ©¥;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) ""))))

(ert-deftest ac-php-search/namespace-not-found ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Foo;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-namespace-name) ""))))

;;;; FQCN

(ert-deftest ac-php-search/fqcn-std-class ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "class Foo;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-full-class-name) "\\Foo"))))

(ert-deftest ac-php-search/fqcn-complex-name ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "<?php

namespace Symfony\\Component\\Console\\Descriptor;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class JsonDescriptor;"
   (goto-char (point-max))
   (should (string= (ac-php-get-cur-full-class-name)
                    "\\Symfony\\Component\\Console\\Descriptor\\JsonDescriptor"))))

(ert-deftest ac-php-search/fqcn-class-absence ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "<?php namespace Acme;

function helper() {}"
   (goto-char (point-max))
   (should (eq (ac-php-get-cur-full-class-name) nil))))

;;;; Annotated variable

(ert-deftest ac-php-search/annotated-var-std-class ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "function hello() {
    /** @var Extension $extension */
}"
   (goto-char (point-max))
   (should (string= (ac-php-get-annotated-var-class "extension")
                    "Extension"))))

(ert-deftest ac-php-search/annotated-var-complex-class ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "function hello() {
    /** @var \\Symfony\\Component\\Console\\Descriptor\\JsonDescriptor $extension */
}"
   (goto-char (point-max))
   (should (string= (ac-php-get-annotated-var-class "extension")
                    "\\Symfony\\Component\\Console\\Descriptor\\JsonDescriptor"))))

(ert-deftest ac-php-search/annotated-var-not-found ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer
   "function hello() {
    /** @var Extension $variable */
}"
   (goto-char (point-max))
   (should (eq (ac-php-get-annotated-var-class "extension") nil))))

(ert-deftest ac-php-search/annotated-var-out-of-scope ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer "
function hello() {
    /** @var Extension $extension */
}

function test() {

}"
   (goto-char (point-max))
   (should (eq (ac-php-get-annotated-var-class "extension") nil))))

(ert-deftest ac-php-search/annotated-var-out-correct-scope ()
  :tags '(re search)
  (ac-php-test-with-temp-buffer "
function hello() {
    /** @var Extension $extension */
}

function test() {
    /** @var Fake $extension */
}"
   (goto-char (point-max))
   (should (string= (ac-php-get-annotated-var-class "extension") "Fake"))))

(provide 'ac-php-search-test)
;;; ac-php-search-test.el ends here
