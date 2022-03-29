<?php

namespace App\Adapters\Database;

use App\Plugins\Database\SqLite;

interface Database
{
    public static function table(string $name): SqLite;

    public static function beginTransaction(): SqLite;
}