<?php

namespace Bonfim\Component\Database;

trait Statement
{
    private $statement;
    private $attributes = [];

    public function create(string $table, array $attributes): self
    {
        $this->attributes = $attributes;
        $this->statement  = "INSERT INTO `{$table}` (`";
        $this->statement .= Tool::getAttributesKey($attributes);
        $this->statement .= '`) VALUES (:';
        $this->statement .= Tool::getAttributesValue($attributes) . ')';
        return $this;
    }

    public function all(string $table): self
    {
        $this->statement = "SELECT * FROM `{$table}`";
        return $this;
    }

    public function select(string $table, array $columns): self
    {
        $this->statement = 'SELECT `' . Tool::columns($columns) . "` FROM `{$table}`";
        return $this;
    }

    public function update(string $table, array $attributes): self
    {
        $set = '';
        $key = array_keys($attributes);
        $pop = array_pop($key);

        foreach ($attributes as $key => $value) {
            $set .= ($key == $pop) ? '' : "`{$key}` = :{$key}, ";
        }

        $set .= "`{$pop}` = :{$pop}";

        $this->statement = "UPDATE `{$table}` SET {$set}";
        return $this;
    }

    public function delete(string $table): self
    {
        $this->statement = "DELETE FROM `{$table}`";
        return $this;
    }
}
