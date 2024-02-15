<?php
namespace System;
use System\Database\Forge;
use System\Database\Table;

class DB {

    protected $queryFinal;

    public static function hasTable($table)
    {
        $container = new \System\Container;
        $container->bind('Database\Connection', function () {
            $connect = new \System\Database\Connection;
            return $connect->create($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
        });

        $res = mysqli_query($container->resolve('Database\Connection'), "show tables like '$table'");

        if (mysqli_num_rows($res) > 0) {

            return true;

        } else {

            return false;

        }
    }

    public static function dropTableIfExists($table)
    {
        if (static::hasTable($table)) {

            $container = new \System\Container;
            $container->bind('Database\Connection', function () {

                $connect = new \System\Database\Connection;
                return $connect->create($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

            });

            $res = mysqli_query($container->resolve('Database\Connection'), 'drop table '.$table);

            if ($res) {
                \Application\Signal::$result = true;
            } else {
                \Application\Signal::$result = false;
            }

        }
    }

    public static function table($table)
    {
        return Table::table($table);
    }

    public static function create(String $table, Object|Array $obj)
    {
        call_user_func($obj, new Forge);
        $final =  str_replace('REPLACE_ME', $table, App::container('Forge\Query'));
        $res = mysqli_query(App::container('Database\Connection'), $final);
        if ($res) {
            \Application\Signal::$result = true;
        } else {
            \Application\Signal::$result = false;
        }
    }

}