<?php

use App\Controllers\LoginController;
use App\Auth;
use App\Controllers\HomeController;
use App\Controllers\Posts;
use App\Controllers\RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Middleware\RegisterMiddleware;
use App\Validation\Validator;
use DI\Container;
use Psr\Container\ContainerInterface;

$container = new Container();
$database = require __DIR__ . '/database.php';
$database($container);

$container->set(Posts::class, fn(ContainerInterface $c) => new Posts($c));
$container->set(Auth::class, fn(ContainerInterface $c) => new Auth($c));
$container->set(LoginController::class, fn(ContainerInterface $c) => new LoginController($c));
$container->set(AuthMiddleware::class, fn(ContainerInterface $c) => new AuthMiddleware($c));
$container->set(RegisterMiddleware::class, fn(ContainerInterface $c) => new RegisterMiddleware($c));

$container->set(Validator::class, fn(ContainerInterface $c) => new Validator($c));
$container->set(Welcome::class, fn(ContainerInterface $c) => new Welcome($c));
$container->set(HomeController::class, fn(ContainerInterface $c) => new HomeController($c));
$container->set(RegisterController::class, fn(ContainerInterface $c)=> new RegisterController($c));




return $container;
