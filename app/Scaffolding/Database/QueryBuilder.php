<?php

namespace App\Scaffolding\Database;

interface QueryBuilder
{
    public function table($name);
    public function insert(array $data);
}