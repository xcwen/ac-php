<?php

namespace Test;

class Testa {


    /**
     * HTTP Cookies
     * @var Testb
     */
    public $v1; 
    
    const  DIR="sss";
    public function set_v1($v){
        $v=trim($v);
        $this->v1=$v;

    }
    public function get_v1(){
        return $v1;
        //
        //$this->set_v1(1);
    }
}