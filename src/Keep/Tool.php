<?php

namespace Keep;

trait Tool
{
    public static function columns(array $columns): string
    {
        return implode('`, `', $columns);
    }

    public static function getAttributesKey(array $attributes): string
    {
        return implode('`, `', array_keys($attributes));
    }

    public static function getAttributesValue(array $attributes): string
    {
        return implode(', :', array_keys($attributes));
    }
}
