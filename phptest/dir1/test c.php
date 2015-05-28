<?php

namespace Test;

class TestD {


    /**
     * @var   string 
     */
    public $v4;
    
    const  DIR="sss";
    public function set_v4($v){
        $v=trim($v);
        $this->v4=$v;
    }

    public function get_v4(){
        return $this->v4;
        //$this->set_v1(1);
    }
}