<?php

namespace App\Adapters\Database;

interface QueryBuilder
{
    public function table($name);
    public function insert(array $data);
    public function select(array $columns = ['*']);
    public function innerJoin(string $table, string $first, string $operator, string $second);
}