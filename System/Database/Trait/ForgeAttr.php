<?php
namespace System\Database\Forge;

trait ForgeAttr {

    public function notNull()
    {
        $this->query[array_key_last($this->query)][] = 'NOT NULL';
        return $this;
    }

    public function autoIncrements()
    {
        $this->query[array_key_last($this->query)][] = 'AUTO_INCREMENT';
        return $this;
    }

    public function key($key)
    {
        $this->query[array_key_last($this->query)][] = 'PRIMARY KEY';
        return $this;
    }

}