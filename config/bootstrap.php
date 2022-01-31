<?php

use App\Auth\AuthController;
use App\Controllers\HomeController ;
use App\Controllers\RegisterController;
use App\Controllers\Welcome;
use App\Validation\Validator;
use DI\Container;
use Psr\Container\ContainerInterface;
use Respect\Validation\Factory;

$container = new Container();
$database = require __DIR__ . '/database.php';
$database($container);

$container->set(AuthController::class, fn(ContainerInterface $c) => new AuthController($c));
$container->set(Validator::class, fn(ContainerInterface $c) => new Validator($c));
$container->set(Welcome::class, fn(ContainerInterface $c) => new Welcome($c));
$container->set(HomeController::class, fn(ContainerInterface $c) => new HomeController($c));
$container->set(RegisterController::class, fn(ContainerInterface $c)=> new RegisterController($c));




return $container;
