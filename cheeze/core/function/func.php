<?php

/**
 * Function
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

function view(String $filename, array $data = [])
{
    if (!empty($data)) extract($data);
    include 'cheeze/route/view/'.$filename.'.php';
}

function response($code = [])
{
    class Response {
        private $code;
        
        public function __construct($data = [])
        {
            if (!empty($data)) $this->code;
        }

        public function json(array $arr, $httpres = [])
        {
            if (!empty($httpres)) http_response_code($httpres);
            header("Content-type: application/json");
            echo json_encode($arr, true);
        }

        
    }
    if ($code == null) return new Response();
    return http_response_code($code);
}

function redirect($location)
{
   return header("Location: $location");
}

function isClosure($data)
{
    $obj = new ReflectionFunction($data);
    return $obj->isClosure();

}