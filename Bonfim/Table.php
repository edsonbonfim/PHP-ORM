<?php

namespace Bonfim\Component\Database;

trait Table
{
    private $table;

    public function setTable(): Database
    {
        return $this;
    }
}
