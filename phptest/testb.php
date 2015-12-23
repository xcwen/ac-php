<?php
namespace Test; 
require "testa.php";
use  Test  as T ;
use  Test\Testa as Ta ;
use  Test\Testb; 

class Testb  extends Ta {

    //define v2 type is Testa in phpdoc
    

	/** @var  $v8 \Test\Testa  */
    /**
       
     */
    public function get_v8(){
        return $this->v2;
    }


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
        parent::set_v1("s");

        $q=new SplQueue ();
    }

    /**
     * define value same as function

     * @return TestB 
     */
    public function get_v1(){
        
    }

    /**
     * define value same as function

     * @var   Testa 
     */
	public $get_v2;

	static public $static_v;





    public function get_tt(){

        $testv = $this->get_v2($this->texx);

        /** @var  $v \Test\Testa  */
        
        $this->v8->do_f("s");
        $this->do_f(sdfa,"ss");
        $this->set_v1($v,$v2);

        $this->set_v1($v,$v2);
        $this->do_f();

        if ($testv->set_v1("s") && $testv->set_v1() ){

        }
        $f=array($this->v8, "do_f" );

        $f();

        $this->get_v2()->set_v1("s");

        $a=Test\CON_NAME;


        
    }
}
/** 
 *
 * @return   T\Testa 
 */

function ff() {
    return 0;
}


function php7_ff(): T\Testb {
    return 0;
}

function php7_ff($test): T\Testb {
    return 0;
}

function php7_ff($a,$b): T\Testb {
    return 0;
}


\Test\CON_NAME
$fadfaf=php7_ff();
split("dsfa","ad");
$t=new Ta();

echo $t->get_v1()."\n" ;
echo Ta::DIR."\n";
(new Ta())->set_v1   ($v);
trim("ss","s");


$s=new Testb($v1,$v2);
(new Ta())->set_v1("s");
