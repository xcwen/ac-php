<?php

namespace Test;

class TestC {


    /**
     * @var   string 
     */
    public $v1;
    
    const  DIR="sss";
    public function set_v1($v){
        $v=trim($v);
        $this->v1=$v;
    }

    public function get_v1(){
        return $this->v1;
        //$this->set_v1(1);
    }
}