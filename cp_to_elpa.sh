#!/bin/bash
cd `dirname $0`
rm -rf ~/.emacs.d/elpa/ac-php-20*/*.elc
rm -rf ~/.emacs.d/elpa/ac-php-core-20*/*.elc
cp -rf ac-php-core.el phpctags ~/.emacs.d/elpa/ac-php-core-20*/
chmod a-w ~/.emacs.d/elpa/ac-php-core-20*/*.el
