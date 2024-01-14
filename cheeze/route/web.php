<?php
use App\Route\Register as Route;
use App\Controller\HomeController;


/**
 * Web route
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

# Set homepage
Route::Homepage(function ()
{
    $file = fopen('cheeze/.env', 'r');
    return view('welcome', ['env_file' => $file]);
});

# Route GET method with Middleware
Route::get('/home', [HomeController::class, 'index']);

Route::post('/home/post', [HomeController::class, 'show']);


# Test
Route::get('/test', function (){
    return view('test');
});