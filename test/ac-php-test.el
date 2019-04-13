;;; ac-php-test.el --- AC PHP: Base test -*- lexical-binding: t; -*-

;; Copyright (C) 2014-2019 jim <xcwenn@qq.com>

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

(ert-deftest ac-php-test-parse-line-2 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt " this->asdfa ( \t (new class1( ))->run()->ss")
    (setq  ret '("class1(" "." "run(" "." "ss" ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-3 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt " $this->func")
    (setq  ret '("this" "." "func"  ))
    (ac-php-test-parse-equal line-txt ret)))

(ert-deftest ac-php-test-parse-line-4 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "this")
    (setq  ret '("this"  ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-5 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return this->sdfa&& this->ttt->ss")
    (setq  ret '("this" "." "ttt" "." "ss"  ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-6 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return this->sdfa ||  ClassT::getV")
    (setq  ret '("ClassT::" "." "getV"   ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-7 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "return (($this->tt())->kk())->ss ")
    (setq  ret '("this" "." "tt("   "." "kk(" "."  "ss"  ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-8 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "\"sdfa\" => $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-10 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "$ss > $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-21 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "  } else  if ($role   == Erole:: ")
    (setq  ret '("Erole::" "."      ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-11 ()
  (let (line-txt  ret )
    (setq line-txt "$ss <= $this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-12 ()
  (let (line-txt  ret )
    (setq line-txt "$this->ss(0 <= $this->tt)->kk ")
    (setq  ret '("this" "." "ss(" "." "kk"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-13 ()
  (let (line-txt  ret )
    (setq line-txt "$this->ss? this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-14 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  tt ")
    (setq  ret '("tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-15 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  if (this->ss?this->tt ")
    (setq  ret '("this" "." "tt"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-16 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  if (this->ss?this->tt:this->kk ")
    (setq  ret '("this" "." "kk"     ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-17 ()
  (let (line-txt  ret )
    (setq line-txt "   \t  parent::ss")
    (setq  ret '( "parent::" "."  "ss"   ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-18 ()
  (let (line-txt  ret )
    (setq line-txt "   \t $v >= $ff? \"sdfa\" : parent::ss . parent::xx")
    (setq  ret '("parent::"  "." "xx"  ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(ert-deftest ac-php-test-parse-line-19 ()
  "text"
  (let (line-txt  ret )
    (setq line-txt "(yii\\web\\Application(config))->ru")
    (setq  ret '("yii\\web\\Application" "." "ru"   ))
    (ac-php-test-parse-equal line-txt ret  )
    ))

(provide 'ac-php-test)
;;; ac-php-test.el ends here
