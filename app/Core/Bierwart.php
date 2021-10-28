<?php

namespace App\Core;

use App\Exceptions\DBException;
use App\Scaffolding\Router;
use App\Scaffolding\DB;

class Bierwart {
	public function printHelloWorld() {
        try {
            $DB = new DB();
        }catch (DBException $e) {
            Router::abort(503, $e->getMessage());
        }
        if ($DB !== null) {
            $DB->query("SELECT * FROM user WHERE 1");
            return $DB->get();
        }
        return 'Whoops, could not connect to the SQLite database!';
    }
}
