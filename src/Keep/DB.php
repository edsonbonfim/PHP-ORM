<?php

namespace Keep;

class DB
{
    private static $db = null;
    private static $driver;

    public static function __callStatic(string $func, array $params)
    {
        return call_user_func_array([self::singleton(), $func], $params);
    }

    public static function config(array $config)
    {
        switch ($config['driver']) {
            case 'mysql':
                self::mysql($config);
                break;
        }
    }

    public static function conn(): void
    {
        self::singleton()->connection(self::$driver);
    }

    public static function singleton(): Database
    {
        if (!isset(self::$db) || is_null(self::$db)) {
            self::$db = new Database;
        }

        return self::$db;
    }

    private static function mysql(array $config): void
    {
        $mysql = new Mysql;
        $mysql->setHost($config['host']);
        $mysql->setDbname($config['dbname']);
        $mysql->setUser($config['user']);
        $mysql->setPass($config['pass']);

        self::$driver = $mysql;
    }
}
