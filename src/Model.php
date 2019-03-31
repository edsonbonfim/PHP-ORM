<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use PDO;
use PDOStatement;
use ReflectionClass;

use Bonfim\ActiveRecord\ActiveRecord as AR;

abstract class Model extends AR
{
    public static function all(): array
    {
        $consulta = AR::execute("SELECT * FROM `".self::getTable()."`");
        return is_null($consulta) ? [] : self::bind($consulta);
    }

    public static function find(string $where, array $values): array
    {
        $consulta = AR::execute("SELECT * FROM `".self::getTable()."` ".$where, $values);
        return is_null($consulta) ? [] : self::bind($consulta);
    }

    public static function select(array $keys, string $cond = '', array $values = []): array
    {
        $q = "SELECT ".implode(', ', $keys)." FROM ".self::getTable()." $cond";
        $consulta = AR::execute($q, $values);
        return is_null($consulta) ? [] : self::bind($consulta);
    }

    public function save(): int
    {
        $this->getProperties($keys, $values);

        $q = "INSERT INTO `".self::getTable()."` (`".implode('`, `', $keys)."`) VALUES (";
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $q .= "?, ";
        }
        $q .= "?)";

        return AR::execute($q, $values)->rowCount();
    }

    public function update(): int
    {
        $this->getProperties($keys, $values);
        $values[] = $this->id;

        $q = "UPDATE `".self::getTable()."` SET " . "`";
        $q .= implode('` = ?, `', $keys);
        $q .= "` = ? WHERE `id` = ?";

        return AR::execute($q, $values)->rowCount();
    }

    public function delete(): int
    {
        return AR::execute("DELETE FROM `".self::getTable()."` WHERE `id` = ?", [$this->id])->rowCount();
    }

    public static function deleteAll(): int
    {
        return AR::execute("DELETE FROM `".self::getTable()."`")->rowCount();
    }

    private static function getTable(): string
    {
        $class = new ReflectionClass(get_called_class());
        return Inflect::pluralize(strtolower($class->getShortName()));
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
