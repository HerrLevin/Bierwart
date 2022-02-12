<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\AccountController;
use App\Core\BeverageController;
use App\Core\Bierwart;
use App\Core\UserController;
use App\Scaffolding\Router;


$request = $_SERVER['REQUEST_URI'];
$router = new Router($request);

$router->get('/', Bierwart::class, 'printHelloWorld');
$router->get('/useroverview', UserController::class, 'getUserOverview');
$router->get('/accountbalances', AccountController::class, 'getBalances');
$router->get('/drinksoverview', BeverageController::class, 'getDrinksOverview');
$router->post('/orderBeverage', BeverageController::class, 'createBeverageMovement');
$router->post('/createBeverage', BeverageController::class, 'createBeverage');
$router->post('/createDrinkType', BeverageController::class, 'createDrinkType');

Router::abort();