<?php
class Testb  extends Testa{
    //define v2 type is Testa in comment

    /**
     * @var   Test\Testa 
     */
	public $v2;

    public function get_v2(){
        $this->v2->get_v1();
    }
}