<?php

namespace Dc\Core\Route\Annotation\Mapping;


class RequestMapping
{
    /**
     * Action routing path
     *
     * @var string
     * @Required()
     */
    private $route = '';

    /**
     * Route name
     *
     * @var string
     */
    private $name = '';

    /**
     * Routing supported HTTP method set
     *
     * @var array
     */
    private $method = '';

    /**
     * Route path
     * @var string
     */
    protected  $routePath = "";
    /**
     * Routing path params binding. eg. {"id"="\d+"}
     *
     * @var array
     */
    private $params = [];

    /**
     * RequestMapping constructor.
     *
     * @param array $values
     */
    public function __construct($class_comment,$method_comment,$re_object,$method)
    {

        $class_regex = '#@Controller\((.*)\)#i';
        preg_match($class_regex, $class_comment, $controller_info);
        $prefix = $controller_info[1];
        $explode = explode("=", $prefix);
        $class_prefix = str_replace(array("\"", "'"), "", $explode[1]);
        $method_regex = '#RequestMapping\((.*)\)#i';
        preg_match($method_regex, $method_comment, $method_info);
        $prefix = $method_info[1];
        $explode = explode("=", $prefix);
        $action = str_replace(array("\"", "'"), "", $explode[1]);

        //解析路由
        $this->routePath = $class_prefix."/".$action;

        //解析方法Get
        $this->method = "GET";

        $this->handler = $re_object->getName() . "@" . $method->getName();


        $values = [];
        if (isset($values['value'])) {
            $this->routePath = $class_prefix."/".$method;
        } elseif (isset($values['route'])) {
            $this->route = (string)$values['route'];
        }

        if (isset($values['name'])) {
            $this->name = (string)$values['name'];
        }

        if (isset($values['method'])) {
            $this->method = (array)$values['method'];
        }

        if (isset($values['params'])) {
            $this->params = (array)$values['params'];
        }
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(){
        return $this->handler;
    }
}
