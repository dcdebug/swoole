<?php

namespace  Dc\Core\Route;

class Route{

    /**
     * Route info
     *  'get'=>[[
     *      'routepath'=>'index/index',
     *      'handle'=>'app\api\controller\indexCoteroller',
     *      ]
     * ],
     *  'post'=>[
     * }
     * @var array
     */
    static $route = [];

    protected  static $instance = null;
    private  function __construct()
    {
    }
    public static function get_instance(){
        if(self::$instance){
            return self::$instance;
        }
        return new self();
    }

    /**
     * 添加route
     */
    public  static  function addRoute($method ,$routeinfo){
        self::$route[$method][]=$routeinfo;
    }

    /**
     * dispatch route
     */
    public  static  function dispatch($method,$pathinfo){
        $is_found = false;
        if(isset(self::$route[$method])){
            foreach(self::$route[$method] as $v){
                if($v['routePath'] == $pathinfo){
                    //找到了路由
                    //获取控制器类名和方法
                    $class_method = explode("@",$v['handle']);
                    $controller_name = $class_method[0];
                    $method_name = $class_method[1];
                    $is_found = true;
                    return (new $controller_name())->$method_name();
                }
            }
            if($is_found === false){
                return "not found controller and method ";
            }
        }
    }
}