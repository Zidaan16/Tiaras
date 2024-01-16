<?php
namespace App\Controller;
use App\Http\Request;
use App\Model\Home;

class HomeController extends Controllers{

    # The obj must be static
    public static function index()
    {
        return view('homepage');
    }

    /**
     * Show method with request
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
    public static function show(Request $value)
    {
        // Return bool
        $result = $value->validate([
            $value->username => 'string|min:4',
            $value->password => 'string'
        ]);

        echo ($result)? true : false;
    }

}