<?php
namespace App\Route;

use core\Routes;

/**
 * Route register
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Register extends Routes{

    public static function get(String $url, $data = []){
        $url = ltrim($url, '/');
        $url = rtrim($url, '/');
        $arr =[
            'method' => 'GET',
            'url' => $url,
            'data' => $data
        ];
        self::$tempList = $arr;
        array_push(self::$list, $arr);
        return new self;
    }

    public static function post(String $url, $data = []){
        $url = ltrim($url, '/');
        $arr =[
            'method' => 'POST',
            'url' => $url,
            'data' => $data
        ];
        self::$tempList = $arr;
        array_push(self::$list, $arr);
        return new self;
    }
    
    public static function Homepage($data = []){
        if (!isset($_GET['url'])){
            call_user_func($data);
            exit;
        }
    }
    
}