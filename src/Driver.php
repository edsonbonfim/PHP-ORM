<?php

namespace Bonfim\Component\Database;

abstract class Driver
{
    protected $host;
    protected $port = 80;
    protected $dbname;
    protected $user;
    protected $pass;
    protected $charset = 'utf8';

    abstract public function getDsn(): string;

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    public function setDbname(string $dbname): void
    {
        $this->dbname = $dbname;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }
}
