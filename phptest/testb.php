<?php
namespace Test; 
use  Test  as T ;

class Testb  extends Testa {

    //define v2 type is Testa in phpdoc
    
	/** @var  $v8 \Test\Testa  */
	/** @var  $v5 \Test\Testa  */

    /**
     * @var   T\Testa 
     */
	public $v2;


    /** 
	 *
     * @return   T\Testa 
	 */

    public function get_v2(){
        return $this->v2;
        $this->v2->set_v1("ss");
        $this->v8->set_v1("sss");

    }



    public function get_tt(){

        /**  @var  $testv Test\Testa  */
        $testv=$this->get_v2();
        $testv->set_v1("ss");
        if ($testv->set_v1("s") && $testv->set_v1() ){
            
        }

        $this->get_v2()->set_v1("ss");
        
    }

}

function ff(){
    return 0;


}