<?php

namespace Bonfim\Component\Database;

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

    public function exec(): ?Database
    {
        if ($this->exec->execute()) {
            return $this;
        }

        return null;
    }

    public function execute(): ?Database
    {
        return $this->prepare()->bind()->exec();
    }

    public function getQuery(): string
    {
        return $this->statement.' '.$this->clause.$this->operators.$this->keyword;
    }
}
