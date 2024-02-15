<?php
namespace System\Database;
use System\Container;
use System\Database\Forge\ForgeAttr;

class Forge {

    private $queryFinal = [];

    public $query = [];
    public $exposeQuery;

    public function id()
    {
        $this->integer('id', 10)->notNull()->autoIncrements()->key('PRIMARY');
        return $this;
    }

    public function string(String $name, Int $length = 255)
    {
        $this->query[$name][] = $name;
        $this->query[$name][] = "VARCHAR($length)";

        return $this;
    }

    public function integer(String $name, Int $length = 255)
    {
        $this->query[$name][] = $name;
        $this->query[$name][] = "INTEGER($length)";

        return $this;
    }

    public function __destruct()
    {
        foreach ($this->query as $key => $value) {
            $this->queryFinal[] = implode(' ', $value);
        }

        $query = "CREATE TABLE REPLACE_ME (".implode(', ', $this->queryFinal).")";

        $container = new Container;
        
        $container->bind('Database\Connection', function () {

            $connect = new Connection;
            return $connect->create($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

        });
        $container->bind('Forge\Query', function () use ($query) {
            return $query;
        });

        \System\App::setContainer($container);
    }

    use ForgeAttr;

}