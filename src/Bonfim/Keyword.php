<?php

namespace Bonfim\Component\Database;

trait Keyword
{
    private $keyword = '';

    public function orderBy(array $columns, $order): self
    {
        $this->keyword = 'ORDER BY `' . Tool::columns($columns) . "` {$order}";
        return $this;
    }
}
