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
        ActiveRecord::$dbh = new PDO($dsn, $user, $pass);
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
        if (ActiveRecord::prepare($query)->execute($parameters)) {
            return ActiveRecord::$sth;
        }
        return null;
    }

    public static function exec(string $sql): int
    {
        return ActiveRecord::$dbh->exec($sql);
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
