<?php

namespace Test;

class Testf {


    /**
     * @var   string
     */
    public $v5;
    //
    const  DIR="sss";
    public function set_v5($v){
        $v=trim($v);
        $this->v5=$v;
    }

    public function get_v5(){
        return $this->v5;
        //$this->set_v1(1);
    }
}
