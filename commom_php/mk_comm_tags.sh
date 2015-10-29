cd `dirname $0`

function gen_comm_tags_data(){
    echo "(provide 'ac-php-comm-tags-data)"
    echo "(defvar ac-php-comm-tags-data-list "
    echo "'"
    sed -e "s/[A-Za-z0-9]\+.php:[0-9]\+/S/g"  ./.tags/tags-data.el
    echo ")"
}

gen_comm_tags_data > ../ac-php-comm-tags-data.el
