<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use PDO;
use PDOStatement;
use ReflectionClass;

use Bonfim\ActiveRecord\ActiveRecord as AR;

abstract class Model
{
    public static function all(): array
    {
        return self::bind(AR::execute("SELECT * FROM `".self::getTable()."`"));
    }

    public static function find(string $where, array $values): array
    {
        return self::bind(AR::execute("SELECT * FROM `".self::getTable()."` ".$where, $values));
    }

    public function select(array $keys, string $cond, array $values): array
    {
        $q = "SELECT ".implode(', ', $keys)." FROM ".self::getTable()." $cond";
        return self::bind(AR::execute($q, $values));
    }

    public function save(): ?PDOStatement
    {
        $this->getProperties($keys, $values);

        $q = "INSERT INTO `".self::getTable()."` (`".implode('`, `', $keys)."`) VALUES (";
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $q .= "?, ";
        }
        $q .= "?)";

        return AR::execute($q, $values);
    }

    public function update(): ?PDOStatement
    {
        $this->getProperties($keys, $values);
        $values[] = $this->id;

        $q = "UPDATE `".self::getTable()."` SET " . "`";
        $q .= implode('` = ?, `', $keys);
        $q .= "` = ? WHERE `id` = ?";

        return AR::execute($q, $values);
    }

    public function delete(): ?PDOStatement
    {
        return AR::execute("DELETE FROM `".self::getTable()."` WHERE `id` = ?", [$this->id]);
    }

    private static function getTable(): string
    {
        $class = new ReflectionClass(get_called_class());
        return Inflect::pluralize($class->getName());
    }

    private function getProperties(&$keys, &$values)
    {
        $properties = (new ReflectionClass(get_called_class()))->getProperties();

        foreach ($properties as $property) {
            $keys[]   = $property->name;
            $values[] = $this->{$property->name};
        }
    }

    private static function bind(PDOStatement $exec): array
    {
        $resp  = [];
        $class = get_called_class();

        foreach ($exec->fetchAll(PDO::FETCH_OBJ) as $i => $fetch) {
            $resp[$i] = new $class;
            foreach ($fetch as $k => $v) {
                $resp[$i]->$k = $v;
            }
        }

        return $resp;
    }
}
