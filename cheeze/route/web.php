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

Route::get('/', function (){
    return view('welcome');
});

Route::get('test', [HomeController::class, 'index']);

// Middleware auth, check the app/Http/Auth.php to edit the user session, return void
Route::get('dashboard', [HomeController::class, 'index'])->auth('admin');

// Or you can use middleware('name') to customize return, app/Middleware/Auth.php
Route::get('dashboard2', function (){
    return view('test');

})->middleware('Auth');