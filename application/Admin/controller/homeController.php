<?php

namespace App\Admin\Controller;

/**
 * Class homeController
 * @Controller(prefix='/home')
 * @package app\admin\controller
 */
class homeController
{

    /**
     * @RequestMapping(prefix='index');
     */
    public function index()
    {
        return strtolower(__CLASS__) . "/" . strtolower(__FUNCTION__);
    }

    /**
     * @RequestMapping(prefix='test')
     */
    public function test()
    {
        return  "admin ---- home----".strtolower(__FUNCTION__);
    }
}

