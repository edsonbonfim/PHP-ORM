<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class KeywordTest extends TestCase
{
    use \Keep\Keyword;

    public function testOrderBy()
    {
        $this->orderBy(['id', 'login'], 'ASC');
        $this->assertEquals('ORDER BY `id`, `login` ASC', $this->keyword);
    }
}
