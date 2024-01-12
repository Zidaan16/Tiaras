<?php
namespace App\Model;

/**
 * Home Models
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Home extends Models{

    public static function SetTable($table){
        self::$table = $table;
    }

}

# Set table
Home::SetTable('test');