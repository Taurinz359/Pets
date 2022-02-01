<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Controllers\Welcome;
use App\Validation\Validator;
use DI\Container;
use Psr\Container\ContainerInterface;

$container = new Container();
$database = require __DIR__ . '/TestDatabase.php';
$database($container);



$container->set(AuthController::class,fn(ContainerInterface $c) => new AuthController($c));
$container->set(Validator::class, fn(ContainerInterface $c) => new Validator());
$container->set(Welcome::class, fn(ContainerInterface $c) => new Welcome());
$container->set(HomeController::class, fn(ContainerInterface $c) => new HomeController($c));
$container->set(RegisterController::class, fn(ContainerInterface $c)=> new RegisterController($c));




return $container;