<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use ReflectionClass;
use ICanBoogie\Inflector;

abstract class Model extends QueryBuilderFacade
{
    protected static $table = null;
    private $properties = [];

    protected static function getBuilder(): QueryBuilder
    {
        return (new QueryBuilder(get_called_class()))
            ->from(self::getTable());
    }

    public static function join($table, $assoc = null): QueryBuilder
    {
        if (!$assoc) {
            $assoc = "{$table}_id";
        }

        return self::getBuilder()->join(static::$table, $table, $assoc);
    }

    /**
     * @return static|null
     */
    public static function first(): ?self
    {
        return self::getBuilder()->first();
    }

    public function save()
    {
        return self::getBuilder()->insert($this->getProperties());
    }

    public function delete()
    {
        $this->where('id', $this->id);
        return self::getBuilder()->delete();
    }

    public static function getTable(): string
    {
        if (static::$table !== null) {
            return (string) static::$table;
        }

        $class = new ReflectionClass(get_called_class());
        return strtolower(Inflector::get()->pluralize($class->getShortName()));
    }

    private function getProperties(): array
    {
        $res = [];

        $properties = (new ReflectionClass($this))->getProperties() ?? [];
        $properties = array_merge($properties, $this->properties);

        foreach ($properties as $property) {
            if ($this->{$property->name} === null) {
                continue;
            }
            $res[$property->name] = $this->{$property->name};
        }

        return $res;
    }

    public function __set($name, $value)
    {
        $property = new \stdClass();

        $property->name  = $name;
        $property->value = $value;

        $this->properties[$name] = $property;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return null;
        }
        return $this->properties[$name]->value;
    }
}
