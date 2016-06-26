<?php namespace t1;
require_once("t.php");
class A {
    use Instance; 
    public function test () {
        //$this->instance();
    }
};
   ( ac-php-get-syntax-backward  (concat "<\\?php[ \t]+namespace[ \t]+\\(" ac-php-word-re-str "\\)")  1  )