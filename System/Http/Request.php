<?php
namespace App\Http;

class Request {

    public function server($key)
    {
        if (!empty($_SERVER[$key])) return $_SERVER[$key];
    }
    
}