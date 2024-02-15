<?php

$container = new \System\Container;

$container->bind('Load\Model', function () {
    
    return spl_autoload_register(function ($class) {
        $explode = explode('\\', $class);
        $path = "../App/Model/".end($explode).".php";
        if (file_exists($path)) require_once $path;
    });

});

$container->bind('Load\Controller', function () {

    return spl_autoload_register(function ($class) {
        $explode = explode('\\', $class);
        $path = "../App/Controller/".end($explode).".php";
        if (file_exists($path)) require_once $path;
    });

});

$container->resolve('Load\Model');
$container->resolve('Load\Controller');