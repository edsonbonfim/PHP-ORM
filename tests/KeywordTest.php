<?php

use PHPUnit\Framework\TestCase;

class KeywordTest extends TestCase
{
    use Bonfim\Component\Database\Keyword;

    public function testOrderBy()
    {
        $this->orderBy(['id', 'login'], 'ASC');
        $this->assertEquals('ORDER BY `id`, `login` ASC', $this->keyword);
    }
}
