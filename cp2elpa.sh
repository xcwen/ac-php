#!/bin/bash

# This allows the configuration of the package path as follows:
#     - .cp2elpa.sh
#     - PACKAGE_USER_DIR=~/.emacs.d/.local/packages/ .cp2elpa.sh
: ${PACKAGE_USER_DIR:=~/.emacs.d/elpa}

cd `dirname $0`

rm -rf ${PACKAGE_USER_DIR}/ac-php-20*/*.elc
rm -rf ${PACKAGE_USER_DIR}/ac-php-core-20*/*.elc
rm -rf ${PACKAGE_USER_DIR}/company-php-20*/*.elc

cp -rf \
   ac-php-core.el \
   phpctags \
   ac-php-comm-tags-data.* \
   helm-ac-php-apropros.el \
   ${PACKAGE_USER_DIR}/ac-php-core-20*/

cp -rf ac-php.el ${PACKAGE_USER_DIR}/ac-php-20*/
cp -rf company-php.el ${PACKAGE_USER_DIR}/company-php-20*/

chmod a-w ${PACKAGE_USER_DIR}/ac-php-core-20*/*.el

rm -rf ${PACKAGE_USER_DIR}/develop/ac-php-20*/*.elc
rm -rf ${PACKAGE_USER_DIR}/develop/ac-php-core-20*/*.elc
rm -rf ${PACKAGE_USER_DIR}/develop/company-php-20*/*.elc

cp -rf \
   ac-php-core.el \
   phpctags \
   ac-php-comm-tags-data.* \
   helm-ac-php-apropros.el \
   ${PACKAGE_USER_DIR}/develop/ac-php-core-20*/

cp -rf company-php.el ${PACKAGE_USER_DIR}/develop/company-php-20*/

chmod a-w ${PACKAGE_USER_DIR}/develop/ac-php-core-20*/*.el
