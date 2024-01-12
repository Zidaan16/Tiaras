<?php
session_start();
require_once 'app.php';
use core\Routes;

/**
 * Initialize App
 * Check the app.php for edit methods
 * 
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Init extends App{

    private static $result = [];

    public function RouteExec()
    {
        $arr = Routes::$list;
        for ($i=0; $i < count($arr); $i++) { 
            if ($_GET['url'] == $arr[$i]['url']){
                if ($_SERVER['REQUEST_METHOD'] == $arr[$i]['method']) {
                    if (!empty($arr[$i]['data'])){
                        self::$result = [
                            'method' => $arr[$i]['method'],
                            'url' => $arr[$i]['url'],
                            'data' => $arr[$i]['data']
                        ];
                        // print_r(self::$result);
                        // call_user_func($arr[$i]['data']);
                        break;
                    }
                    // exit;
                }else{
                    echo 'Method Not Allowed';
                    exit;
                }
            }
        }
        if (!empty(self::$result)){
            if (self::$result['method'] == 'POST'){
                // require_once 
                $class = new Reflectionclass(self::$result['data'][0]);
                $name = $class->getMethod(self::$result['data'][1]);
                $bool = (empty($name->getParameters()[0]))? False : True;
                if ($bool){
                    $name = $name->getParameters()[0]->getClass()->getName();
                    call_user_func_array(self::$result['data'], [new $name]);
                    exit;
                }
                call_user_func(self::$result['data']);
                exit;
            }else{
                call_user_func(self::$result['data']);
                exit;
            }
        }else{
            echo '404';
        }
    }
}

$init = new Init();

$init->LoadEnv();
$init->LoadDB();
$init->LoadCore();
$init->LoadModel();
$init->LoadController();
$init->LoadRequest();
$init->LoadRoute();

$init->RouteExec();