<?php

namespace App\Plugins\Database;


use App\Adapters\Database\Database;

class DB implements Database
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