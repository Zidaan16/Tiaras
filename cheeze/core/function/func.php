<?php

/**
 * Function
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

function view(String $filename, array $data = []) {
    if (!empty($data)) extract($data);
    include 'cheeze/route/view/'.$filename.'.php';
}

function JsonResponse($data = [], $httpcode = []) {
    header('Content-Type: application/json;');
    echo json_encode($data);
}

function response($code = []) {
    class response
    {
        private $code;
        
        public function __construct($data = []){
            if (!empty($data)) $this->code;
        }

        public function json(array $arr, $httpres = []){
            if ($httpres == 200) http_response_code(200);
            if ($httpres == 404) http_response_code(404);
            header("Content-type: application/json");
            return json_encode($arr, true);
        }

        
    }
    if ($code == null) return new response();
    return http_response_code($code);
}