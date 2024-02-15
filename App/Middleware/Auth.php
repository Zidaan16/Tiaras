<?php
namespace App\Middleware;
use App\Http\Request;

class Auth {

    public function handle(Request $request, \Closure $continue)
    {
        echo 'middleware';

        return $continue();
    }

}