<?php

namespace Keep;

use PDO;
use stdClass;
use Exception;

class Model
{
    public $attributes = [];

    public function __set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return null;
    }

    public static function __callStatic($findBy, $attributes)
    {
        $findBy = str_replace('find_by_', '', $findBy);

        $explode = explode('_', $findBy);

        $operator = $explode[1];

        $obj = get_called_class();
        $obj = new $obj;

        $find = DB::all(self::getTable())
            ->where(array_values(array_filter($explode))[0], $attributes[0])
            ->$operator(@array_values(array_filter($explode))[2], @$attributes[1])
            ->execute();

        if ($find->rowCount() === 0) {
            return null;
        }

        foreach ($find->fetch(PDO::FETCH_OBJ) as $key => $value) {
            $obj->$key = $value;
        }

        return $obj;
    }

    public function save()
    {
        return DB::create(self::getTable(), $this->attributes)->execute();
    }

    public static function find(int $id)
    {
        $obj = get_called_class();
        $obj = new $obj;

        $find = DB::all(self::getTable())->where('id', $id)->execute();

        if ($find->rowCount() === 0) {
            return null;
        }

        foreach ($find->fetch(PDO::FETCH_OBJ) as $key => $value) {
            $obj->$key = $value;
        }

        return $obj;
    }

    public static function all()
    {
        $find = DB::all(self::getTable())->execute();

        if ($find) {
            return $find->fetchAll(PDO::FETCH_OBJ);
        }

        return false;
    }

    public function delete()
    {
        return DB::delete(self::getTable())->where('id', $this->id)->execute();
    }

    public function update()
    {
        $attributes = $this->attributes;
        unset($attributes['id']);

        return DB::update(self::getTable(), $attributes)->where('id', $this->id)->execute();
    }

    private static function getTable(): string
    {
        $table = explode('\\', strtolower(get_called_class()));
        $table = $table[count($table) - 1];

        return $table;
    }
}
