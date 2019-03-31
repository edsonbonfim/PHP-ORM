<?php

namespace Bonfim\ActiveRecord;

final class Table
{
    private $columns;
    private $last;

    private $pk;
    private $fk;

    private $references = "";
    private $onupdate = "";
    private $ondelete = "";

    public function __set($name, $value)
    {
        $this->columns[$name] = $value;
    }

    public function __get($name)
    {
        return $this->columns[$name];
    }

    public function __call($name, $arguments)
    {
        $name = strtolower(str_replace('get', '', $name));
        return $this->$name;
    }

    public function increments(string $name = 'id')
    {
        $this->last = $name;
        $this->$name = "INT AUTO_INCREMENT";
        $this->pk = $name;
        return $this;
    }

    public function timestamps(string $name = 'created_at')
    {
        $this->$name = "TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        return $this;
    }

    public function string(string $name, int $len = 255)
    {
        $this->last = $name;
        $this->$name = "VARCHAR($len)";
        return $this;
    }

    public function integer($name)
    {
        $this->last = $name;
        $this->$name = "INT";
        return $this;
    }

    public function unsigned()
    {
        $this->{$this->last} .= " unsigned";
        return $this;
    }

    public function notNull()
    {
        $this->{$this->last} .= " NOT NULL";
        return $this;
    }

    public function references($table, $name)
    {
        $this->fk = "FOREIGN KEY ($this->last)";
        $this->references = "REFERENCES $table($name)";
        return $this;
    }

    public function onUpdate($method)
    {
        $this->onupdate = "ON UPDATE $method";
        return $this;
    }

    public function onDelete($method)
    {
        $this->ondelete = "ON DELETE $method";
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
