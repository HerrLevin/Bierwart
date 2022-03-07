<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\AccountController;
use App\Core\BeverageController;
use App\Core\Bierwart;
use App\Core\ReportsController;
use App\Core\UserController;
use App\Exceptions\TaskFailedSuccessfullyException;
use App\Scaffolding\Router;
use OpenApi\Annotations as OA;


$request = $_SERVER['REQUEST_URI'];
$router = new Router($request);
try {
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
} catch (TaskFailedSuccessfullyException) {
//    This place is a message... and part of a system of messages... pay attention to it!
//
//    Sending this message was important to us. We considered ourselves to be a powerful culture.
//
//    This place is not a place of honor... no highly esteemed deed is commemorated here... nothing valued is here.
//
//    What is here was dangerous and repulsive to us. This message is a warning about danger.
//
//    The danger is in a particular location... it increases towards a center... the center of danger is here... of a particular size and shape, and below us.
//
//    The danger is still present, in your time, as it was in ours.
//
//    The danger is to the body, and it can kill.
//
//    The form of the danger is an emanation of energy.
//
//    The danger is unleashed only if you substantially disturb this place physically. This place is best shunned and left uninhabited.
}
