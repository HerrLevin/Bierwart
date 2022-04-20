<?php

namespace App\Adapters\Database;

interface QueryBuilder
{
    public function __construct();
    public function __destruct();
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
    public function table($name): static;
    public function insert(array $data);
    public function update(array $data);
    public function select(array $columns = ['*']): static;
    public function innerJoin(string $table, string $first, string $operator, string $second): static;
    public function groupBy(string $group): static;
    public function as(string $alias): static;
    public function query(): string;
    public function where(string $first, string $operator, string $second): static;
    public function andWhere(string $first, string $operator, string $second): static;
    public function orWhere(string $first, string $operator, string $second): static;
    public function get(): bool|array;
    public function execute(): static;
}