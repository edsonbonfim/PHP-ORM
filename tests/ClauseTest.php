<?php

use PHPUnit\Framework\TestCase;

class ClauseTest extends TestCase
{
    use Bonfim\Component\Database\Clause;

    public function testWhere()
    {
        $this->where('id', 1);
        $this->assertEquals('WHERE `id` = :id', $this->clause);
    }
}
