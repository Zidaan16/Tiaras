<?php
namespace App\Controller;
use App\Request\Post;
use App\Model\Home;

class HomeController extends Controllers{

    # The obj must be static
    public static function index()
    {
        return view('homepage');
    }

    /**
     * Show method with POST request
     * 
     * Type validate cheat sheet:
     *  Type|Min/Max length|Nullable or not (default not)
     * 
     * example:
     *  string|min:13
     *  integer|max:16|nullable
     *  
     * 
     * 
     * Copyright 2024 Ahmad Zidan
     * 
     * Follow me :D
     * http://instagram.com/zidaaaaanz
     * 
     */
    public static function show(Post $value)
    {
        $result = $value->validate([
            $value->username => 'string|min:4',
            $value->password => 'string'
        ]);

        echo ($result)? true : false;
    }

}