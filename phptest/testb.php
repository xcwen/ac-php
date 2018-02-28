<?php
namespace Test;
require "testa.php";
use  Test  as T ;
use  Test\Testa as Ta ;
use  Test\Testb;

/**

   @property  \Test\Testa  $v8
   @property  \Test\Testa  $v7 - adfa sdf
   @method \Test\Testa  get_moth( )

   //for complete like  trait


 */
class Testb  extends Testa {


    /**
     * @return $this
     */
    public function get_v8( $a=[] ){
        //$this->v1
        //$this->get_moth( )

    }
    use Instance;


    /**
     * @var   T\Testa
     */
    public $v2;

    /**
     * @var string $name        Should contain a description
     * @var string $description Should contain a description
     */
    protected $name, $description;


    /**
     *
     * @return   T\Testa
     */

    public function get_v2(){

        return $this->v1;
        $this->v2->set_v1("ss");
        $this->v8->set_v1("sss");
        parent::set_v1("s");

        $q=new SplQueue ();
    }

    public function get_v1() :self {

    }

    /**
     * define value same as function

     * @var   Testa
     */
    public $get_v2;

    static public $static_v;
    static public $static_v2;





    public function get_tt(){

        $testv = $this->get_v2($this->texx);
        $this->get_v1() ;

        /** @var   \Test\Testa  $v */

        $this->v8->do_f("s");
        $this->do_f(sdfa,"ss");
        $this->set_v1($v,$v2);


        if ($testv->set_v1("s") && $testv->set_v1() ){

        }
        $f=array($this->v8, "do_f" );

        $f();


        $this->get_v2( )->set_v1("s");

        $a=Test\CON_NAME;

        //$this->name
    }
}
/**
 *
 * @return   T\Testa
 */

function ff() {
    return 0;
}




split("dsfa","ad");
/**
   @var Ta
 */
$t=new Ta();

echo $t->get_v1()."\n" ;
echo Ta::DIR."\n";
(new Ta())->set_v1   ($v);
trim("ss","s");

$s=new \Test\Testb($v1,$v2);
$s->get_v1();

(new Ta())->set_v1("s");
