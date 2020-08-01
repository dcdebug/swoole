<?php
namespace  Dc\Core\Config;

//配置文件封装类

class ConfigFactory{
    static $configMap = [];
    protected  static $instance = null;
    private function __construct()
    {
    }

    public static function get_instance(){
        if(self::$instance){
            return self::$instance;
        }
        return new self();
    }
    //禁止克隆
    private  function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 加载配置文件
     */
    public function load(){
        $files = glob(CONFIG_PATH."/*.php");
        if(!empty($files)){
            foreach($files as $dir=>$fileName){
                self::$configMap += include $fileName;
            }
        }
    }
    public function get($key){
            if(isset(self::$configMap[$key])){
                return self::$configMap[$key];
            }else{
                return false;
            }
    }

}
