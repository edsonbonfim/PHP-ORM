<?php

namespace Keep;

/**
 * Class Mysql
 * @package Keep
 */
class Mysql extends Driver
{
    /**
     * @return string
     */
    public function getDsn(): string
    {
        return "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
    }
}
