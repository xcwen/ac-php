<?php
namespace Test; 
require "testa.php";
use  Test  as T ;
use  Test\Testa as Ta ;
use  Test\Testd; 

class Testb  extends Ta {

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


        $testv = $this->get_v2($this->texx);
        $testv->set_v1("ss");

        if ($testv->set_v1("s") && $testv->set_v1() ){
            
        }
        $this->get_v2()->set_v1("ss");
    }

}
/** 
 *
 * @return   T\Testa 
 */

function ff(){
    return 0;
}
$t=new Ta();
echo $t->get_v1()."\n" ;
echo Ta::DIR."\n";