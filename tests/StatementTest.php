<?php

use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase
{
    use Bonfim\Component\Database\Statement;

    public function testCreate()
    {
        $this->create('users', [
            'name'     => 'Edson Onildo',
            'login'    => 'edsononildo',
            'password' => 1234
        ]);
        $this->assertEquals('INSERT INTO `users` (`name`, `login`, `password`) VALUES (:name, :login, :password)', $this->statement);
    }

    public function testAll()
    {
        $this->all('users');
        $this->assertEquals('SELECT * FROM `users`', $this->statement);
    }

    public function testSelect()
    {
        $this->select('users', [
            'name',
            'login',
            'password'
        ]);
        $this->assertEquals('SELECT `name`, `login`, `password` FROM `users`', $this->statement);
    }

    public function testUpdate()
    {
        $this->update('users', [
            'name'     => 'Bonfim',
            'login'    => 'admin',
            'password' => 4321
        ]);
        $this->assertEquals('UPDATE `users` SET `name` = :name, `login` = :login, `password` = :password', $this->statement);
    }

    public function testDelete()
    {
        $this->delete('users');
        $this->assertEquals('DELETE FROM `users`', $this->statement);
    }
}
