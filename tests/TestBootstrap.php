<?php

use App\Auth;
use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Validation\Validator;
use DI\Container;
use Psr\Container\ContainerInterface;

$container = new Container();
$database = require __DIR__ . '/TestDatabase.php';
$database($container);

$container->set(Auth::class, fn(ContainerInterface $c) => new Auth($c));
$container->set(AuthMiddleware::class, fn(ContainerInterface $c) => new AuthMiddleware($c));
$container->set(LoginController::class, fn(ContainerInterface $c) => new LoginController($c));
$container->set(Validator::class, fn(ContainerInterface $c) => new Validator());
$container->set(Welcome::class, fn(ContainerInterface $c) => new Welcome());
$container->set(HomeController::class, fn(ContainerInterface $c) => new HomeController($c));
$container->set(RegisterController::class, fn(ContainerInterface $c)=> new RegisterController($c));

return $container;
