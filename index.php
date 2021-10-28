<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Bierwart;
use App\Scaffolding\Router;


$request = $_SERVER['REQUEST_URI'];
$router = new Router($request);

$router->get('/', Bierwart::class, 'printHelloWorld');

Router::abort();