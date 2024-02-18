<?php
namespace System\Database;
use System\Database\Forge;

class Paper {

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

    public static function create(String $table, Object|Array $obj)
    {
        call_user_func($obj, new Forge);
        $final =  str_replace('REPLACE_ME', $table, \System\App::container('Forge\Query'));
        $res = mysqli_query(\System\App::container('Database\Connection'), $final);
        if ($res) {
            \Application\Signal::$result = true;
        } else {
            \Application\Signal::$result = false;
        }
        // mysqli_begin_transaction()
        // mysqli_rollback()
    }

}