<?php

namespace  App\Admin\Controller;

/**
 * @Controller(prefix='/index')
 */

class indexController {

    /**
     * @RequestMapping(perfix='index')
     */
    public function index(){
        return "admin -- index -- ".strtolower(__FUNCTION__);
    }
}
