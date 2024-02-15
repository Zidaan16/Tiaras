<?php
namespace System;

class App {

    private static $container;

    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    public static function container(String $resolve)
    {
        return static::$container->resolve($resolve);
    }

}