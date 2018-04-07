<?php

namespace Keep;

trait Clause
{
    private $clause = '';
    private $attributes = [];

    public function where(string $key, $value): self
    {
        $this->attributes[$key] = $value;
        $this->clause = "WHERE `{$key}` = :{$key}";
        return $this;
    }
}
