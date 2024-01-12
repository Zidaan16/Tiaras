<?php
namespace DB;

use DB\Config;

/**
 * MySQL query builder
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Builder extends Config{

    public static $table;
    public static $data;

    public static function Table(String $table)
    {
        self::$table = $table;
        return new self;
    }

    public static function select(String $key)
    {
        self::$data = "select * from ".self::$table;
        return new self;
    }

    public static function where(String $key, String $mode, String $key2)
    {
        $query = " where $key $mode '$key2'";
        self::$data = self::$data.$query;
        return new self;
    }

    // Finishing

    public static function qr()
    {
        return mysqli_query(self::$conn, self::$data);
    }

    public static function get() :array
    { 
        return mysqli_fetch_array(self::qr(), true);
    }
    
    public static function assoc() :array
    {
        return mysqli_fetch_assoc(self::qr());
    }

}