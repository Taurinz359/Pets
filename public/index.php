<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Manager;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

$routes= require_once __DIR__ .'/../config/routes.php';
$status =$routes($app);

$container = require  __DIR__ . '/../config/bootstrap.php';
AppFactory::setContainer($container);

$capsule = new Manager();
$capsule->addConnection($container->get('db'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container->set([
    \App\Controllers\HomeController::class =>  function (\Psr\Container\ContainerInterface $c) {
        return new \App\Controllers\Controller($c);
    }
]);

$app->run();
