<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Manager;
use Slim\Factory\AppFactory;

$container = require __DIR__ . '/../config/bootstrap.php';
AppFactory::setContainer($container);
$app = AppFactory::create();

$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

$routes = require_once __DIR__ . '/../config/routes.php';
$status = $routes($app);

$capsule = new Manager();
$capsule->addConnection($container->get('db'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app->run();
