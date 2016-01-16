cd `dirname $0`

function gen_comm_tags_data(){
    echo "(defvar ac-php-comm-tags-data-list "
    echo "'"
    sed -e "s/[A-Za-z0-9]\+.php:[0-9]\+/S/g"  ~/.ac-php/tags-home-*-ac-php-commom_php/tags-data.el
    echo ")"
    echo "(provide 'ac-php-comm-tags-data)"
}

gen_comm_tags_data > ../ac-php-comm-tags-data.el
