<?php

/**
 * @Controller(prefix='public')
 * Class PublicController
 */
class PublicController {

    /**
     * @RequestMapping(prefix='index')
     * @return string
     */
    public function index(){
        return strtolower(__FUNCTION__);
    }

}
