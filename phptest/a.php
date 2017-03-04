<?php namespace t1;
require_once("t.php");
class A {
    use Instance; 
    public function test () {
        //$this->instance();
        $this->instance($options );
    }
};