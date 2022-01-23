<?php

namespace App\Scaffolding\Database;

use App\Config;
use App\Exceptions\DBException;
use PDO;
use PDOException;
use PDOStatement;

class SqLite implements QueryBuilder
{

    private $table;
    private $query;
    private $keys;
    private $values;
    private null|PDO $pdo;
    private bool|PDOStatement $pdostatement;

    /**
     * @throws DBException
     */
    public function __construct() {
        try {
            $this->pdo = new PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
        } catch (PDOException $e) {
            throw new DBException($e->getMessage());
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }

    public function table($name): static
    {
        $this->table = $name;
        return $this;
    }

    public function insert(array $data): bool|int
    {
        $this->decodeInsertData($data);

        $replacements = [
            "db_table" => $this->table,
            "db_keys" => $this->keys,
            "db_values" => $this->values
        ];
        $query = strtr("INSERT INTO db_table (db_keys) VALUES (db_values);", $replacements);
        var_dump($query);
        die();
        return $this->pdo->exec($query);
    }

    public function select(array $columns = ['*']): static
    {
        $this->decodeInsertData($columns);

        $replacements = ['db_columns' => $this->values, 'db_table' => $this->table];

        $this->query = strtr(" SELECT db_columns FROM db_table ", $replacements);
        return $this;
    }

    public function innerJoin(string $table, string $first, string $operator, string $second): static
    {
        $replacements = [
            'db_table' => $table,
            'db_first' => $first,
            'db_operator' => $operator,
            'db_second' => $second
        ];

        $this->query .= strtr(" INNER JOIN db_table ON db_first db_operator db_second ", $replacements);
        return $this;
    }

    private function decodeInsertData(array $data) {
        ksort($data);
        $this->keys = implode(",", array_keys($data));
        $this->values = implode(",", array_values($data));
        return $this;
    }

    public function get(): bool|array
    {
        $this->prepareQuery();
        return $this->pdostatement->fetchAll(PDO::FETCH_CLASS);
    }

    private function prepareQuery(): void
    {
        $this->pdostatement = $this->pdo->query($this->query . ";");
    }

    private function execute(): bool {
        return $this->pdostatement->execute();
    }
}