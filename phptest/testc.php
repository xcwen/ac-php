<?php
use \Test\Testa;

abstract class Testc {


    /**
     * @var   Testa
     */
    public $v3;


    const  DIR="sss";
    public function set_v3($v){
        $v=trim($v);
        $this->v3=$v;
    }

    public function get_v3(){
        return $this->v3;
        //$this->set_v1(1);

    }


}
