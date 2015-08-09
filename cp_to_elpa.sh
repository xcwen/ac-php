#!/bin/bash
cd `dirname $0`
rm -rf ~/.emacs.d/elpa/ac-php-2015*/*.elc
cp -rf *.el phpctags ~/.emacs.d/elpa/ac-php-2015*/
