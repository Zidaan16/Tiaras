<?php
namespace core;

/**
 * Route function
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Routes {

    public static $list = [];

    public static function add(String $name, String $value): void
    {
        self::$list[array_key_last(self::$list)][$name] = $value;
    }

    public static function auth(String $name): void
    {
        self::add('auth', $name);
    }

    public static function middleware(String $name): void
    {
        self::add('midware', $name);
    }
    

}