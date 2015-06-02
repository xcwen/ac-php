<?php
namespace Test; 
//use  Test\Testa as Ta ;

class Testb  extends Testc {

    //define v2 type is Testa in phpdoc
    
	/** @var  $v8 \Test\Testa  */
	/** @var  $v5 \Test\Testa  */

    /**
     * @var   \Test\Testa 
     */
	public $v2;


    /** 
	 *
	 * @return  Testa 
	 */

    public function get_v2(){
        return $this->v2;
        $this->v2->set_v1("ss");
        $this->v8->set_v1("sss");
    }



    public function get_tt(){
        $testv=$this->get_v2();
        $testv->set_v1("ss");
        static::get_v2();
    }

}