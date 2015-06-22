#!/bin/bash
cd `dirname $0`
emacs -batch -l ert -l ac-php-test.el -f ert-run-tests-batch-and-exit
