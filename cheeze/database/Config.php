<?php
namespace DB;

/**
 * MySQL Configuration
 * Check the .env for configuration
 * 
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Config {

    public static $conn;

    public static function connect(){
        self::$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $db = mysqli_select_db(self::$conn, $_ENV['DB_NAME']);
    }

}

Config::connect();