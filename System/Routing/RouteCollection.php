<?php
namespace System\Routing;

class RouteCollection {

    private static $route = [];

    public static function add($route)
    {
        static::$route[] = $route;
    }

    public static function get()
    {
        return static::$route;
    }

}