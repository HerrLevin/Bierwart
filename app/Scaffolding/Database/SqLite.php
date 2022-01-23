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

    public function table($name)
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
        return $this->pdo->exec($query);
    }

    private function decodeInsertData(array $data) {
        ksort($data);
        $this->keys = implode(",", array_keys($data));
        $this->values = implode(",", array_values($data));
        return $this;
    }

    private function get(): bool|array
    {
        return $this->pdostatement->fetchAll(PDO::FETCH_CLASS);
    }

    private function execute(): bool {
        return $this->pdostatement->execute();
    }
}