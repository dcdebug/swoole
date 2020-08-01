<?php

namespace  App\Api\Controller;

/**
 * @controller(prefix="/test")
 * Class testController
 * @package app\api\controller
 */
class testController{
    /**
     * @RequestMapping(route="index")
     */
    public function index(){
        return strtolower(__FUNCTION__);
    }

    /**
     * @RequestMapping(route="test")
     * @return string
     */
    public function test(){
        return strtolower(__FUNCTION__);
    }
}
