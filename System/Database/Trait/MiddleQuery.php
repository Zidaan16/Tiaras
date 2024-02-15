<?php
namespace System\Database;

trait MiddleQuery {

    public function where($key, $logic, $value)
    {
        if (is_string($value)) $value = "'$value'";
        $this->query[] = "where $key $logic $value";
        return $this;
    }

}