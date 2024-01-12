<?php
namespace App\Model;

use DB\Builder;

/**
 * Models
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Models extends Builder{

    public static function All()
    {
        return mysqli_fetch_all(self::select('*')->qr());
    }

    public static function NumRows($result)
    {
        return mysqli_num_rows($result);
    }

}