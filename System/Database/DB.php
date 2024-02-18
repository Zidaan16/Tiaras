<?php
namespace System;
use System\Database\Table;

class DB {

    protected $queryFinal;

    public static function table($table)
    {
        return Table::table($table);
    }

}