<?php

namespace Test;


const CON_NAME="sss";
define("NAME_CONSTANT", "Hello world.");

class Testa {


    /**
     * @var   string 
     */
    public $v1;
    
    const DIR="sss";
    public function set_v1($v){

        $v=trim($v);
        $this->v1=$v;
    }



    public function get_v1(){
        return "sfa" ;
        //$this->set_v1(1);
    }
}