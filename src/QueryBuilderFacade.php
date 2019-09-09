<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use stdClass;

abstract class QueryBuilderFacade
{
    abstract protected static function getBuilder(): QueryBuilder;

    /**
     * @param $columns
     * @return QueryBuilder|static
     */
    public static function select($columns): QueryBuilder
    {
        return static::getBuilder()->select($columns);
    }

    /**
     * @param string $column
     * @param $value
     * @param string $op
     * @param string $cond
     * @return QueryBuilder|static
     */
    public static function where(string $column, $value, string $op = '=', string $cond = 'AND'): QueryBuilder
    {
        return static::getBuilder()->where($column, $value, $op, $cond);
    }

    /**
     * @param string $column
     * @param $query
     * @param string $cond
     * @return QueryBuilder|static
     */
    public static function in(string $column, $query, $cond = 'AND'): QueryBuilder
    {
        return static::getBuilder()->in($column, $query, $cond);
    }

    /**
     * @param string $column
     * @param $query
     * @param string $cond
     * @return QueryBuilder|static
     */
    public static function notIn(string $column, $query, $cond = 'AND'): QueryBuilder
    {
        return static::getBuilder()->notIn($column, $query, $cond);
    }

    /**
     * @param $query
     * @return QueryBuilder|static
     */
    public static function union($query): QueryBuilder
    {
        return static::getBuilder()->union($query);
    }

    /**
     * @param int $n
     * @return QueryBuilder|static
     */
    public static function limit(int $n): QueryBuilder
    {
        return static::getBuilder()->limit($n);
    }

    /**
     * @return QueryBuilder|static
     */
    public static function rand(): QueryBuilder
    {
        return static::getBuilder()->rand();
    }

    /**
     * @param $expression
     * @return QueryBuilder|static
     */
    public static function order($expression): QueryBuilder
    {
        return static::getBuilder()->order($expression);
    }

    /**
     * @return QueryBuilder[]|stdClass[]|null|static
     */
    public static function all()
    {
        return static::getBuilder()->get();
    }

    /**
     * @param $id
     * @return QueryBuilder|null|static
     */
    public static function find($id)
    {
        return static::getBuilder()->find($id);
    }

    /**
     * @return QueryBuilder|null|static
     */
    public static function last()
    {
        return static::getBuilder()->last();
    }

    public static function count()
    {
        return static::getBuilder()->count();
    }

    public static function max(string $column)
    {
        return static::getBuilder()->max($column);
    }

    public static function min(string $column)
    {
        return static::getBuilder()->min($column);
    }

    public static function avg(string $column)
    {
        return static::getBuilder()->avg($column);
    }

    public static function exists()
    {
        return static::getBuilder()->exists();
    }

    /**
     * @return static
     */
    public static function newInstance(): self
    {
        return new static;
    }
}
