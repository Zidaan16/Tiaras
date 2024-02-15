<?php
namespace System\Feature;

class Middleware {

    public static function handle()
    {
        return new static;
    }

    public static function ea()
    {
        echo 'ea';
        return new static;
    }

    public function __destruct()
    {
        echo 'destruct';
    }

}