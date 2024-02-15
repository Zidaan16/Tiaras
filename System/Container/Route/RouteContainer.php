<?php
namespace System\Container;

class RouteContainer {

    private static $controller;
    private static $http;
    private static $uri;
    private static $method;
    private static $group;
    private static $middleware;
    private static $prefix;
    private static $name;

    public static function put(String $key, $value)
    {
        switch ($key) {
            case 'controller':
                static::$controller = $value;
                break;

            case 'middleware':
                static::$middleware = $value;
                break;

            case 'http':
                static::$http = $value;
                break;
            
            case 'prefix':
                static::$prefix = $value;
                break;

            case 'name':
                static::$name = $value;
                break;

        }
    }

    public static function get(String $key)
    {
        switch ($key) {
            case 'controller':
                return static::$controller;

            case 'middleware':
                return static::$middleware;

            case 'http':
                return static::$middleware;

            case 'prefix':
                return static::$prefix;

            case 'name':
                return static::$name;
        }
    }

    public static function set(Array $route)
    {
        static::$extends = $route;
    }

    public static function clear()
    {
        static::$controller = null;
        static::$http = null;
        static::$uri = null;
        static::$method = null;
        static::$group = null;
        static::$middleware = null;
        static::$prefix = null;
        static::$name = null;
    }

}