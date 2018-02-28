<?php

namespace Test;


const CON_NAME="sss";
define("NAME_CONSTANT", "Hello world.");

class Testa  {


    /**
     * @var   string
     */
    public $v1 ;

    public $v3  ;
    /**
     * @var   string
     */
    const DIR="sss";
    public function &set_v1($v,$v2= -1){

        $this->do_f($v1,$v2,$v3 );
        $v=trim($v);
        $this->v1=$v;
        $this->DIR;
        $this->php7_func();
    }

    public function __construct(   ){
        $this->do_f("ss");
        $this->do_f($v1);
    }

    public function do_f( $v1 ,$v2=0x1001, $v3 =0777 ){
        return "sfa" ;
        //$this->set_v1(1);
        $this->do_f($v1,$v2 );
        json_encode("s","s");
        $this->set_v1("s","d");
        $this->do_f("s","ss");
    }


    /**
     *
     * @return   Testa|null
     */
    public function get_v1(){
        return "sfa" ;
        //$this->get_v1()->
        //$this->set_v1(1);
    }
    //声明函数返回值类型的写法和参数类型
    function php7_func( ): Testa{
        return new Testa() ;
    }

}
