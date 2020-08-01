<?php

return [
    'Route' => function () {
        return \Dc\Core\Route\Route::get_instance(); //修改成单利模式，不需要重复实例话
    },
    'Config' => function () {
        return  \Dc\Core\Config\ConfigFactory::get_instance();
    },
    'HttpServer'=>function(){
        return  \Dc\Core\Http\HttpServer::get_instance();
    }
];
