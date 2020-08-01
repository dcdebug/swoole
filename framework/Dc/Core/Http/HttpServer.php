<?php

namespace Dc\Core\Http;

use Dc\Core\Bean\BeanFactory;
use Doctrine\Common\Annotations\Annotation;


class HttpServer
{

    static $instance =null;
    private  function __construct()
    {
    }

    /**
     * 获取实例
     */
    public static function get_instance(){
        if(self::$instance){
            return self::$instance;
        }
        return new self();
    }



    /**
     * httpServer进程启动
     */
    public function run()
    {
        //获取http_server的配置
        $http_config = BeanFactory::get('config')->get('http_server');
        $http_server = new \swoole_http_server($http_config['host'], $http_config['port']);
        $http_server->on("start", function ($server) use ($http_config) {
            echo "swoole http server is started at http://localhost:" . $http_config['port'] . PHP_EOL;
        });

        $http_server->set($http_config['setting']);
        $http_server->on("workerstart",[$this,'onWorkerStart']);
        $http_server->on("request", [$this,'onRequest']);
        $http_server->start();

    }

    /**
     * 处理用户请求
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        //去除icon请求:
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->end();
            return;
        }
        //$response->header("Content-Type", "application/json");
        $request_path_info = $request->server['path_info'];
        echo "request path info is " . $request_path_info . PHP_EOL;

        $request_method = $request->server['request_method'];

        echo "request method is " . $request_method . PHP_EOL;
        //路由分发
        //$result = Route::dispatch($request_method, $request_path_info);
        //修改成用BeanFactory
        $result = BeanFactory::get("route")::dispatch($request_method, $request_path_info);
        //var_dump($result);
        $response->end($result);
    }


    /**
     * 服务启动
     */
    public function onWorkerStart()
    {
            //一些必要的基础需求，可以放到这里来处理
            echo date("Y-m-d H:i:s")." worker Start".PHP_EOL;
    }
}
