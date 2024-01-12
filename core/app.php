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
        $file = fopen('.env', 'r');
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
                $path = 'database/'.$class[1].'.php';
                if (file_exists($path)){
                    require_once 'database/'.$class[1].'.php';
                }
            }
        });
    }

    public function LoadCore()
    {
        $core = [
            'core/function/func.php',
            'core/Routes.php',
            'core/Register.php'
            
        ];
        for ($i=0; $i < count($core); $i++) { 
            require_once $core[$i];
        }
    }

    public function LoadRoute()
    {
        require_once 'route/web.php';
    }

    public function LoadModel()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'app/Model/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'app/Model/'.$class[2].'.php';
                }
            }
        });
    }

    public function LoadController()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'app/Controller/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'app/Controller/'.$class[2].'.php';
                }
            }
        });
    }

    public function LoadRequest()
    {
        spl_autoload_register(function($class){
            $class = explode('\\', $class);
            if (!empty($class[2])){
                $path = 'app/Request/'.$class[2].'.php';
                if (file_exists($path)){
                    require_once 'app/Request/'.$class[2].'.php';
                }
            }
        });
    }

}
