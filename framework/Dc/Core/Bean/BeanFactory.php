<?php
/**
 * Created by PhpStorm.
 * User: darry
 * Date: 2020-04-21
 * Time: 22:05
 */

namespace Dc\Core\Bean;


/**
 * Bean容器
 * Class BeanFactory
 * @package Dc\Core\Bean
 */
class BeanFactory
{

    private static $container = [];

    public static function set(string $name, callable $func)
    {
        self::$container[strtolower($name)] = $func;
    }

    public static function get(string $name)
    {
        if (isset(self::$container[strtolower($name)])) {
            return (self::$container[strtolower($name)])();
        }
        return null;
    }

}
