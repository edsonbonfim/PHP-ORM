<?php

declare(strict_types=1);

namespace Bonfim\ActiveRecord;

use PDO;
use PDOStatement;

class ActiveRecord
{
    private static $dbh;
    private static $sth;

    public static function conn(string $dsn, string $user, string $pass)
    {
        ActiveRecord::$dbh = new PDO($dsn, $user, $pass, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);
        ActiveRecord::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private static function getConn(): PDO
    {
        return ActiveRecord::$dbh;
    }

    private static function prepare(string $query): PDOStatement
    {
        return ActiveRecord::$sth = ActiveRecord::getConn()->prepare(trim($query));
    }

    public function execute(string $query, array $parameters = []): ?PDOStatement
    {
        $query = trim(preg_replace('/\s\s*/', ' ', $query));
        if (ActiveRecord::prepare($query)->execute($parameters)) {
            return ActiveRecord::$sth;
        }
        return null;
    }

    public function exec(string $sql): ?PDOStatement
    {
        $sql = trim(preg_replace('/\s\s*/', ' ', $sql));
        var_dump($sql);
        if (ActiveRecord::$dbh->exec($sql) !== false) {
            return self::$sth;
        }
        return null;
    }

    public static function transaction($callback)
    {
        self::$dbh->beginTransaction();

        try {
            $callback();
            self::$dbh->commit();
        } catch (\Exception $e) {
            self::$dbh->rollBack();
            throw $e;
        }
    }

    protected function lastInsertId()
    {
        return self::$dbh->lastInsertId();
    }
}
