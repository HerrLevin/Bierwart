<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use Bierwart\Bierwart;
use Bierwart\Router;


$request = $_SERVER['REQUEST_URI'];
$router = new Router($request);

$router->get('/', Bierwart::class, 'printHelloWorld');

Router::abort();