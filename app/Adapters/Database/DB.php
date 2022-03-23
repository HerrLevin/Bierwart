<?php

namespace App\Adapters\Database;

use App\Plugins\Database\SqLite;


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