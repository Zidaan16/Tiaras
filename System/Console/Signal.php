<?php
namespace Application;

class Signal {

    public static $result;

    private static $service;

    public static function service($value)
    {
        static::$service = $value;
    }

    public static function getService()
    {
        return static::$service;
    }

}