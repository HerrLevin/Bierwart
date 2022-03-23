<?php

namespace App\Adapters\Database;


class DB
{
    public static function table(string $name): SqLite
    {
        $sqlite = new SqLite();
        $sqlite->table(name: $name);
        return $sqlite;
    }

    public static function beginTransaction(): SqLite
    {
        $sqlite = new SqLite();
        $sqlite->beginTransaction();
        return $sqlite;
    }
}