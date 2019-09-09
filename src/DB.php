<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

class DB extends QueryBuilderFacade
{
    protected static function getBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }

    public static function from(string $table): QueryBuilder
    {
        return self::getBuilder()->from($table);
    }

    public static function join($table1, $table2, $assoc): QueryBuilder
    {
        return static::getBuilder()->join($table1, $table2, $assoc);
    }

    public static function first(): self
    {
        return static::getBuilder()->first();
    }

    public static function delete()
    {
        return static::getBuilder()->delete();
    }
}
