<?php

namespace App\Test\Controller;

/**
 * Class testController
 * @Controller(prefix='/test')
 * @package app\test\controller
 */
class testController{

    /**
     * @RequestMapping(prefix='index');
     * @return string
     */
    public function index(){
        return strtolower(__CLASS__)."/".strtolower(__FUNCTION__);
    }

    /**
     * @RequestMapping(prefix='test')
     * @return string
     */
    public function test(){
        return strtolower(__CLASS__)."/".strtolower(__FUNCTION__);
    }
}
