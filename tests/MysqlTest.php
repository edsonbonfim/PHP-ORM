<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use PHPUnit\Framework\TestCase;
use PDOException;

class MysqlTest extends TestCase
{
    protected function SetUp(): void
    {
        ActiveRecord::config('mysql:host=localhost;dbname=demo', 'root', 'batatapalha123');
    }

    public function testEmptySelectAll()
    {
        $this->assertCount(0, Post::all());
    }
}
