<?php
namespace System\Database;
use System\Database\Select;

trait Query {

    public static function select($select = "*")
    {
        if (!empty(static::$table)) {

            return new Select("select $select from ".static::$table);

        } else {

            $nonStatic = new static;
            return new Select("select $select from ".$nonStatic->table);

        }
    }

}