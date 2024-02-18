<?php
namespace App\Http;

class Request {

    protected $requestMethod;

    private $result;

    public function __construct()
    {
        $this->requestMethod = $_POST;
    }

    public function __get($name)
    {
        return $this->requestMethod[$name];
    }

    public function server($key)
    {
        if (!empty($_SERVER[$key])) return $_SERVER[$key];
    }
    
    public function header(String $string)
    {
        return header($string);
    }

    public function path()
    {
        if (!empty($_SERVER['REQUEST_URI']))
        {

            $this->result = $_SERVER['REQUEST_URI'];
            return $_SERVER['REQUEST_URI'];
        }
    }

    public function clean()
    {
        return trim($this->result, '/');
    }

}