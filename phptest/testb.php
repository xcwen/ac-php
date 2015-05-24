<?php
namespace Test; 
use  Test\Testa as Ta ;

class Testb  extends Ta{

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

        $testv=$this->get_v2()->v1;
        static::get_v2();
    }

}