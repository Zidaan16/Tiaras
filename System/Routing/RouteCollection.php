<?php
namespace System\Routing;

class RouteCollection {

    private static $route = [];
    public static $name = [];
    public static $id = 0;

    public static function add($route)
    {
        static::$route[] = $route;
    }

    public static function get()
    {
        return static::$route;
    }

}