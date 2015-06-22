#!/bin/bash
cd `dirname $0`
rm -f  ../ac-php.elc
emacs -batch -l ert -l ac-php-test.el -f ert-run-tests-batch-and-exit
