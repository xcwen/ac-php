<?php

namespace Test;


const CON_NAME="sss";
define("NAME_CONSTANT", "Hello world.");

class Testa {


    /**
     * @var   string 
     */
    public $v1;
    
    /**
     * @var   string 
     */
    const DIR="sss";

    public function set_v1($v,$v2){
        $v=trim($v);
        $this->v1=$v;
        $this->DIR;
    }

    public function __construct(   ){
        $this->do_f("ss");
    }

    public function do_f( $v1 ,$v2=0  , $v3 =0 ){
        return "sfa" ;
        //$this->set_v1(1);
        $this->do_f($v1,$v2 );
        json_encode("s","s");
        $this->set_v1("s","d");
        $this->do_f("s","ss");
    }



    public function get_v1(){
        return "sfa" ;

        //$this->set_v1(1);
    }
}










