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

    public function __construct()
    {
        $this->LoadEnv();
        $this->LoadDB();
        $this->LoadCore();
        $this->LoadModel();
        $this->LoadController();
        $this->LoadRequest();
        $this->LoadRoute();
        $this->RouteExec();
        $this->HttpResponse(http_response_code());
    }
    
    public function RouteExec()
    {
        $arr = Routes::$list;
        $url = rtrim($_GET['url'], '/');
        for ($i=0; $i < count($arr); $i++) { 
            if ($url == $arr[$i]['url']){
                if ($_SERVER['REQUEST_METHOD'] == $arr[$i]['method']) {
                    if (!empty($arr[$i]['data'])){
                        self::$result = [
                            'method' => $arr[$i]['method'],
                            'url' => $arr[$i]['url'],
                            'data' => $arr[$i]['data']
                        ];
                        break;
                    }
                }else{
                    echo 'Method Not Allowed';
                    exit;
                }
            }
        }
        if (!empty(self::$result)){
            if (self::$result['method'] == 'POST'){
                $class = new Reflectionclass(self::$result['data'][0]);
                $name = $class->getMethod(self::$result['data'][1]);
                $bool = (empty($name->getParameters()[0]))? False : True;
                if ($bool){
                    $name = $name->getParameters()[0]->getType()->getName();
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
            http_response_code(404);
        }
    }

    private function HttpResponse($function)
    {
        if ($function == 404) echo 404;
    }
}

new Init();
