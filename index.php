<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use App\Adapters\Controllers\AccountController;
use App\Adapters\Controllers\BeverageController;
use App\Adapters\Controllers\Bierwart;
use App\Adapters\Controllers\ReportsController;
use App\Adapters\Controllers\UserController;
use App\Adapters\Router;


$request = $_SERVER['REQUEST_URI'];
$router = new Router($request);
$router->get('/', Bierwart::class, 'getHelloWorld');
$router->get('/useroverview', UserController::class, 'getUserOverview');
$router->post('/createUser', UserController::class, 'createUser');
$router->post('/createAccountMovement', AccountController::class, 'createAccountMovement');
$router->get('/accountbalances', AccountController::class, 'getBalances');
$router->get('/drinksoverview', BeverageController::class, 'getDrinksOverview');
$router->post('/orderBeverage', BeverageController::class, 'createBeverageMovement');
$router->post('/createBeverage', BeverageController::class, 'createBeverage');
$router->post('/createDrinkType', BeverageController::class, 'createDrinkType');
$router->get('/generateReport', ReportsController::class, 'generateReport');

Router::abort();
