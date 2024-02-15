<?php
namespace System\Database;

class Table {

    static $table;

    public static function table($table)
    {
        static::$table = $table;
        return new static;
    }

    use Query;

}