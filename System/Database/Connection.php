<?php
namespace System\Database;
use System\Container;

class Connection {

    public $connect;

    public function create($db, $host, $user, $pass)
    {
        $con = mysqli_connect($host, $user, $pass);
        mysqli_select_db($con, $db);
        return $con;
    }

}