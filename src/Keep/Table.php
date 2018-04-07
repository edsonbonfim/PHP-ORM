<?php

namespace Keep;

trait Table
{
    private $table;

    public function setTable(): Database
    {
        return $this;
    }
}
