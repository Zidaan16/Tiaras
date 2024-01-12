<?php
namespace App\Middleware;

class Auth {

    public function run() :void
    {
        if (empty($_SESSION['admin'])){
            echo 'Not Authenticated';
            exit;
        }
    }

}