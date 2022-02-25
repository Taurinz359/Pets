<?php

use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\LogoutController;
use App\Controllers\PostsController;
use App\Controllers\RegisterController as RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Middleware\RegisterMiddleware;
use Slim\App;

return static function (App $app) {
    $app->redirect('/', '/posts');
    $app->get('/login', [LoginController::class, 'showLogin']);
    $app->post('/login', [LoginController::class, 'checkLogin']);
    $app->get('/posts', [PostsController::class,'showPosts']);
    $app->post('/posts', [PostsController::class,'writePost']);
    $app->get('/post/{id}', [PostsController::class,'showPost']);
    $app->get('/logout', [LogoutController::class,'logout']);

    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->post('/register', [RegisterController::class, 'checkValidate']);
    $app->get('/home', [HomeController::class, 'index'])->add(new AuthMiddleware($app->getContainer()));
};
