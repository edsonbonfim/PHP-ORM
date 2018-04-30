<?php

namespace Keep;

/**
 * Trait Table
 * @package Keep
 */
trait Table
{
    /**
     * @var
     */
    private $table;

    /**
     * @return Database
     */
    public function setTable(): Database
    {
        return $this;
    }
}
