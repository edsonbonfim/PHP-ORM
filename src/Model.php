<?php

namespace Bonfim\Component\Database;

use stdClass;

class Model
{
    public $attributes = [];

    public function __set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function save(): bool
    {
        return DB::create(self::getTable(), $this->attributes)->execute();
    }

    public static function find(int $id)
    {
        $find = DB::all(self::getTable())->where('id', $id)->execute();

        if ($find) {
            return $find->fetch();
        }

        return false;
    }

    private static function getTable(): string
    {
        return strtolower(get_called_class());
    }
}
