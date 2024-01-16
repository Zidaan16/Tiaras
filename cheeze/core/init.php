<?php
session_start();
require_once 'app.php';
use core\Routes;
use App\Http\Auth;

/**
 * Initialize
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
        $this->LoadHttp();
        $this->LoadRoute();
        $this->RouteExec();
        $this->HttpResponse(http_response_code());
    }
    
    public function RouteExec()
    {
        if (empty($_GET['url'])) $_GET['url'] = "";
        $url = rtrim($_GET['url'], '/');
        $arr = Routes::$list;
        for ($i=0; $i < count($arr); $i++) { 
            if ($url == $arr[$i]['url']){

                # Run the middleware
                if (!empty($arr[$i]['midware'])){
                    self::RunMiddleware($arr[$i]['midware']);
                }elseif (!empty($arr[$i]['auth'])) {
                    if (empty($_SESSION[$arr[$i]['auth']])) redirect(Auth::$redirect);
                }
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

            // Execute this when result not a closure
            if (is_array(self::$result['data'])){
                $class = new Reflectionclass(self::$result['data'][0]);
                $name = $class->getMethod(self::$result['data'][1]);
                $bool = (empty($name->getParameters()[0]))? False : True;
                if ($bool){
                    $args = array();
                    for ($i=0; $i < count($name->getParameters()); $i++) { 
                        $class = $name->getParameters()[$i]->getType()->getName();
                        array_push($args, new $class());
                    }
                    call_user_func_array(self::$result['data'], $args);
                    exit;
                }
                call_user_func(self::$result['data']);
                exit;

            // Execute this when result is a closure
            }else{
                call_user_func(self::$result['data']);
                exit;
            }
        }else{
            http_response_code(404);
        }
        echo 404;
        exit;
    }

    private function HttpResponse($function)
    {
        if ($function == 404) echo 404;
    }
}

new Init();
