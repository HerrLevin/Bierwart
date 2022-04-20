<?php

namespace App\Adapters\Database;


use App\Plugins\Database\SqLite;

class DB
{
    private static QueryBuilder $queryBuilder;

    public static function table(string $name): SqLite
    {
        self::$queryBuilder = new SqLite();
        self::$queryBuilder->table(name: $name);
        return self::$queryBuilder;
    }

    public static function beginTransaction(): SqLite
    {
        self::$queryBuilder = new SqLite();
        self::$queryBuilder->beginTransaction();
        return self::$queryBuilder;
    }
}