<?php

namespace Dc;

use Dc\Core\Bean\BeanFactory;
use Dc\Core\Route\Annotation\Mapping\RequestMapping;
use Dc\Core\Route\Annotation\Parser\RequestMappingParser;
use Dc\Core\Route\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class App
{


    protected $instance = null;
    protected $beanFile = "Bean.php";


    public function Run()
    {

        //使用doctrine/annotations注解
        echo date("Y-m-d H:i:s") . "  Start Run ..." . PHP_EOL;


        AnnotationReader::
        //加载路由注解
        $this->init();
        $this->initRouteAnnotation();
        //载入配置文件
        $this->loadConfig();
        BeanFactory::get("HttpServer")->run();
    }

    protected function test()
    {

        $start = memory_get_usage();
        echo $start . PHP_EOL;
        $j = 1;
        for ($i = 0; $i <= 100000000; $i++) {
            $j++;
        }
        $end = memory_get_usage();
        echo $end . PHP_EOL;

        echo $use = $end - $start;
        echo PHP_EOL;

    }

    /**
     * 加载注解组件
     */
    public function initRouteAnnotation()
    {
        //扫描目录下的文件
        $dir_modules = $this->parseModule();
        foreach ($dir_modules as $module) {
            $dirs = $this->tree($module['module_path']);
            if (!empty($dirs)) {
                foreach ($dirs as $file) {
                    if (file_exists($file)) {
                        $namespace = $this->parseNamespace($file);
                        $file_name = basename($file, ".php");
                        //获取文件
                        $class_controller_name = $namespace . "\\" . $file_name;
                        $object = new $class_controller_name();
                        $re_object = new \ReflectionClass($object);
                        $class_comment = $re_object->getDocComment();
                        //找到Controller注解
                        //$class_prefix = strtolower($this->parseClass($class_comment));

                        foreach ($re_object->getMethods() as $method) {
                            $method_comment = $method->getDocComment();
                            //搜集信息（路由）
                            $annotation = new RequestMapping($class_comment, $method_comment, $re_object, $method);

                            //执行逻辑
                            (new RequestMappingParser())->parse($annotation);


                        }
                    } else {
                        echo date("Y-m-d H:i:s") . " not found $file" . PHP_EOL;
                    }
                }
            } else {
                echo "empty dirs :" . APP_PATH . "/Api/controller/*";
                return false;
            }
        }

    }

    /**
     * self-swoft初始化
     */
    public function init()
    {
        define("APP", "application");
        define("ROOT_PATH", dirname(dirname(__DIR__))); //root dir
        define("APP_PATH", ROOT_PATH . "/" . APP);    //app dir
        define("CONFIG_PATH",ROOT_PATH."/config"); //config dir
        //初始化的时候，载入容器
        $bean = require_once APP_PATH . "/" . $this->beanFile;
        //var_dump($bean);
        //Bean容器
        foreach ($bean as $k => $v) {
            BeanFactory::set($k,$v);
        }
    }

    /**
     * Parse module
     */
    public function parseModule()
    {
        //admin,api，test等等
        $application_dirs = glob(APP_PATH . "/*");

        if (empty($application_dirs)) {
            echo "not application module";
            return false;
        }
        $dirs_name = [];
        foreach ($application_dirs as $key => $dir) {
            if (is_dir($dir)) {
                $dirs_name[$key]['module_path'] = $dir;
                $dirs_name[$key]['module_name'] = strtolower(basename($dir));
            }
        }

        return $dirs_name;
    }

    /**
     * 获取namespace 配置
     * @param $filename
     * @return string
     */
    public function parseNamespace($filename)
    {
        $string = file_get_contents($filename, false, null, 0, 500);
        $namespace_regex = "#namespace(.*?);#i";
        preg_match($namespace_regex, $string, $namespace_info);
        if (empty($namespace_info)) {
            echo $filename . " not found namespace defined" . PHP_EOL;
        } else {
            return trim($namespace_info[1]);
        }
    }

    /**
     * parse class
     */
    public function parseClass($class_comment)
    {
        $class_regex = '#@Controller\((.*)\)#i';
        preg_match($class_regex, $class_comment, $controller_info);
        $prefix = $controller_info[1];
        $explode = explode("=", $prefix);
        $class_prefix = str_replace(array("\"", "'"), "", $explode[1]);
        return $class_prefix;
    }

    /**
     * parse Method
     * @param $method_comment
     * @return mixed
     */
    public function parseMethod($method_comment)
    {
        $method_regex = '#RequestMapping\((.*)\)#i';
        preg_match($method_regex, $method_comment, $method_info);
        $prefix = $method_info[1];
        $explode = explode("=", $prefix);
        $method = str_replace(array("\"", "'"), "", $explode[1]);
        return $method;
    }

    /**
     * scan dir 's file_name
     * @param $dir
     */
    public function tree($dir)
    {
        //echo $dir . PHP_EOL;
        $dirs = glob($dir . "/*");
        $dirFiles = [];
        //目录列表
        foreach ($dirs as $dire) {
            if (is_dir($dire)) {
                $res = $this->tree($dire);
                if (is_array($dirFiles)) {
                    foreach ($res as $file) {
                        $dirFiles[] = $file;
                    }
                }
            } else {
                $dirFiles[] = $dire;
            }
        }
        return $dirFiles;
    }

    /**
     * 加载配置文件
     */
    public function loadConfig(){
        $config =  BeanFactory::get('config');
        $config_load_result = $config->load();
        //var_dump($config_load_result);


    }
}