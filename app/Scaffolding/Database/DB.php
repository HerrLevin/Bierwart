<?php

namespace App\Scaffolding\Database;


class DB
{
    public static function table(string $name) {
        $sqlite = new SqLite();
        $sqlite->table(name: $name);
        return $sqlite;
    }
}