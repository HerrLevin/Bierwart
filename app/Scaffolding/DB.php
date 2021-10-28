<?php

namespace App\Scaffolding;

use App\Config;
use App\Exceptions\DBException;
use PDO;
use PDOException;
use PDOStatement;

class DB
{
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

    public function query(string $query): bool|PDOStatement
    {
        $this->pdostatement = $this->pdo->query($query);
        return $this->pdostatement;
    }

    public function get(): bool|array
    {
        return $this->pdostatement->fetchAll(PDO::FETCH_CLASS);
    }

    public function execute(): bool {
        return $this->pdostatement->execute();
    }
}