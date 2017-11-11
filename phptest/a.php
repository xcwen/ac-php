<?php
namespace t1;
require_once("t.php");
class A {
    use Instance; 
    public $ss;
    public function test_bb1 ($sss,$sk=null ) {

    }

    public function test (  ) {
        $this->test();
        \trim("s");
    }
};
// PHP 7+ code
$util->setLogger(new class {
        public function log($msg)
        {
            echo $msg;
        }
    });


