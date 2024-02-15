<?php
namespace App\Http;

class Response {

    public function __construct($content, Int $http = 200)
    {
        http_response_code($http);
        $content();
    }

}