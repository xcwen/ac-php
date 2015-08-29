#!/bin/bash
cd `dirname $0`
rm -rf ~/.emacs.d/elpa/ac-php-20*/*.elc
cp -rf *.el phpctags ~/.emacs.d/elpa/ac-php-20*/
chmod a-w ~/.emacs.d/elpa/ac-php-20*/*.el
