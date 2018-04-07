<?php

namespace Keep;

use PDO;
use PDOStatement;
use stdClass;

class Database
{
    use Table;
    use Clause;
    use Keyword;
    use Operators;
    use Statement;

    private $conn;
    private $exec;

    public function connection(Driver $driver): PDO
    {
        return $this->conn = new PDO($driver->getDsn(), $driver->getUser(), $driver->getPass());
    }

    public function prepare(): Database
    {
        $this->exec = $this->conn->prepare($this->getQuery());
        return $this;
    }

    public function bind(): Database
    {
        foreach ($this->attributes as $key => $value) {
            $this->exec->bindValue(":{$key}", $value);
        }

        return $this;
    }

    public function fetch()
    {
        return $this->exec->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll()
    {
        return $this->exec->fetchAll(PDO::FETCH_OBJ);
    }

    public function exec()
    {
        if ($this->exec->execute()) {
            return $this->exec;
        }

        return null;
    }

    public function execute()
    {
        $execute = $this->prepare()->bind()->exec();

        $this->reset();

        return $execute;
    }

    public function getQuery(): string
    {
        return trim($this->statement.' '.$this->clause.' '.$this->operators.' '.$this->keyword);
    }

    public function reset()
    {
        $this->statement = '';
        $this->clause = '';
        $this->operators = '';
        $this->keyword = '';
        $this->attributes = [];
    }
}
