<?php

use App\Controllers\ErrorController;
use App\Controllers\LoginController;
use App\Auth;
use App\Controllers\HomeController;
use App\Controllers\LogoutController;
use App\Controllers\PostsController;
use App\Controllers\RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Middleware\DeleteTokenMiddleware;
use App\Validation\Validator;
use DI\Container;
use Psr\Container\ContainerInterface;

$container = new Container();
$database = require __DIR__ . '/database.php';
$database($container);

$container->set(PostsController::class, fn(ContainerInterface $c) => new PostsController($c));
$container->set(Auth::class, fn(ContainerInterface $c) => new Auth($c));
$container->set(LoginController::class, fn(ContainerInterface $c) => new LoginController($c));
$container->set(AuthMiddleware::class, fn(ContainerInterface $c) => new AuthMiddleware($c));
$container->set(DeleteTokenMiddleware::class, fn(ContainerInterface $c) => new DeleteTokenMiddleware($c));
$container->set(LogoutController::class, fn(ContainerInterface $c) => new LogoutController($c));

$container->set(ErrorController::class, fn(ContainerInterface $c)=> new ErrorController($c));

$container->set(Validator::class, fn(ContainerInterface $c) => new Validator($c));
$container->set(Welcome::class, fn(ContainerInterface $c) => new Welcome($c));
$container->set(HomeController::class, fn(ContainerInterface $c) => new HomeController($c));
$container->set(RegisterController::class, fn(ContainerInterface $c)=> new RegisterController($c));




return $container;
