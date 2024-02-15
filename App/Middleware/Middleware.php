<?php
namespace App;

class Middleware {

    protected $middleware = [
        "auth" => \App\Middleware\Auth::class,
    ];

}