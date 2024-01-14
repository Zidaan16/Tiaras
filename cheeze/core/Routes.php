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
    public static $tempList = [];

    public static function middleware($class = [])
    {
        $i = array_search(self::$tempList, self::$list);
        if ($_GET['url'] == self::$list[$i]['url']){
            require_once 'cheeze/app/Middleware/'.$class.'.php';
            $class = "App\\Middleware\\$class";
            call_user_func(array(new $class, 'run'));
        }
    }

}