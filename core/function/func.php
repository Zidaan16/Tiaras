<?php

/**
 * Function
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

function view(String $filename, $data = []){
    include 'route/view/'.$filename.'.php';
}

function JsonResponse($data = [], $httpcode = []){
    header('Content-Type: application/json;');
    echo json_encode($data);
}