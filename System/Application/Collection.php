<?php
namespace System\Feature;

class Collection {

    private $item;

    public function __construct(String|Array $item)
    {
        $this->item = $item;
    }

    public function count()
    {
        if (is_array($this->item)) return count($this->item);
        else return null;
    }

    public function all()
    {
        return $this->item;
    }

    public function __get($name)
    {
        return $this->item[$name];
    }

    public function get($name)
    {
        return $this->item[$name];
    }

    public function getType()
    {
        return gettype($this->item);
    }

    public function only(Array $only)
    {
        $arr = [];
        foreach ($only as $value) {
            if (!empty($this->item[$value])) $arr[$value] = $this->item[$value];
        }
        return $arr;
    }

}