<?php
namespace System;

class Container {
    
    private $container;

    public function bind(String $key, Object $func)
    {
        $this->container[$key] = $func;
    }

    public function resolve(String $key)
    {
        return call_user_func($this->container[$key]);
    }

}