<?php
namespace System\Database;

class Select {

    public $query = [];

    public function __construct($query)
    {
        $this->query[] = $query;
    }

    public function get()
    {
        $connect = \System\App::container('System\Database\Connection');
        $result = mysqli_query($connect, implode(' ', $this->query));
        return mysqli_fetch_assoc($result);
    }

    public function all()
    {
        $connect = \System\App::container('System\Database\Connection');
        $result = mysqli_query($connect, implode(' ', $this->query));
        return mysqli_fetch_all($result);
    }

    use MiddleQuery;

}