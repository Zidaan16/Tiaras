<?php
namespace App\Http;
use App\Controller\Controllers;

/**
 * Get $_POST request
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Request extends Controllers{

    public $data = array();
    
    public function __construct()
    {
        $this->data = $_POST;
    }

    public function __get($res)
    {
        return $this->data[$res];
    }

}