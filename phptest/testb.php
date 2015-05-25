<?php
namespace Test; 
//use  Test\Testa as Ta ;

class Testb  extends Testa {

    //define v2 type is Testa in phpdoc
    /**
     * @var   \Test\Testa 
     */
	public $v2;

    /** 
	 *
	 * @return  Test\Testa 
	 */

    public function get_v2(){
        return $this->v2;
    }

    public function get_tt(){

        /**  @var  $testv Test\Testa  */
        //$this->
        $testv=$this->get_v2();
        $testv->set_v1("ss");
        static::get_v2();

    }

}