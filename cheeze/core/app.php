<?php

/**
 * App
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class App {
    
    public function LoadEnv(): void
    {
        $file = fopen('cheeze/.env', 'r');
        while (!feof($file)) {
            $line = fgets($file);
            $line = explode('=', $line);
            $_ENV[$line[0]] = trim($line[1]);
        }
    }

    public function LoadDB()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[1])){
                $path = 'cheeze/database/'.$class[1].'.php';
                if (file_exists($path)){
                    require_once 'database/'.$class[1].'.php';
                }
            }
        });
    }

    public function LoadCore()
    {
        $core = [
            'cheeze/core/function/func.php',
            'cheeze/core/Routes.php',
            'cheeze/core/Register.php'
        ];
        for ($i=0; $i < count($core); $i++) { 
            require_once $core[$i];
        }
    }

    public function LoadRoute()
    {
        require_once 'cheeze/route/web.php';
    }

    public function LoadModel()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'cheeze/app/Model/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'cheeze/app/Model/'.$class[2].'.php';
                }
            }
        });
    }

    public function LoadController()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'cheeze/app/Controller/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'cheeze/app/Controller/'.$class[2].'.php';
                }
            }
        });
    }

    public function LoadHttp()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'cheeze/app/Http/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'cheeze/app/Http/'.$class[2].'.php';
                }
            }
        });
    }

    public function RunMiddleware(String $name)
    {
        require_once 'cheeze/app/Middleware/'.$name.'.php';
        $class = "App\\Middleware\\$name";
        call_user_func(array(new $class, 'run'));
    }

}
