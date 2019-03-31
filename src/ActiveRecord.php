<?php

declare(strict_types=1);

/**
 * activerecord.php é uma biblioteca PHP que permite ao desenvolvedor
 * trabalhar com banco de dados usando o padrão de projeto Active Record
 * (https://en.wikipedia.org/wiki/Active_record_pattern)
 */

namespace Bonfim\ActiveRecord;

use PDO;
use PDOStatement;

class ActiveRecord
{
    private static $dbh;
    private static $sth;

    public static function conn(string $dsn, string $user, string $pass): void
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

    protected static function execute(string $query, array $parameters = []): ?PDOStatement
    {
        if (ActiveRecord::prepare($query)->execute($parameters)) {
            return ActiveRecord::$sth;
        }
        return null;
    }

    protected static function exec(string $sql): int
    {
        return ActiveRecord::$dbh->exec($sql);
    }
}
