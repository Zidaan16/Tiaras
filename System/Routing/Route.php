<?php
namespace App\Http;
use System\Routing\RouteHandler;

class Route {

    public static function get(String $uri, Array|Object|String $method)
    {
        return new RouteHandler([
            'http' => 'GET',
            'uri' => $uri,
            'method' => $method
        ]);
    }

    public static function post(String $uri, Array|Object|String $method)
    {
        return new RouteHandler([
            'http' => 'POST',
            'uri' => $uri,
            'method' => $method
        ]);
    }

    public static function name(String $name)
    {
        return new RouteHandler(['name' => $name]);
    }

    public static function middleware(Array|String $name)
    {
        return new RouteHandler(['middleware' => $name]);
    }

    public static function controller(String $controller)
    {
        return new RouteHandler(['controller' => $controller]);
    }

    public static function prefix(String $prefix)
    {
        return new RouteHandler(['prefix' => $prefix]);
    }

    public static function group(Object $group)
    {
        return new RouteHandler($group);
    }

}