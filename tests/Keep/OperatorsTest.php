<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class OperatorsTest extends TestCase
{
    use \Keep\Operators;

    public function testAnd()
    {
        $this->and('id', 1);
        $this->assertEquals('AND `id` = :id', $this->operators);
    }

    public function testOr()
    {
        $this->or('id', 1);
        $this->assertEquals('OR `id` = :id', $this->operators);
    }

    public function testNot()
    {
        $this->not('id', 1);
        $this->assertEquals('NOT `id` = :id', $this->operators);
    }
}
