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

    $app->get('/posts', [PostsController::class,'showPosts']);
    $app->get('/login', [LoginController::class, 'showLogin']);
    $app->get('/posts/create', [PostsController::class, 'showCreateForm'])->add(new AuthMiddleware($app->getContainer()));
    $app->get('/post/{id}', [PostsController::class, 'showCreateForm']);
    $app->get('/logout', [LogoutController::class,'logout']);
    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->get('/home', [HomeController::class, 'index'])->add(new AuthMiddleware($app->getContainer()));

    $app->post('/posts',[PostsController::class, 'validatePostsData'])->add(new AuthMiddleware($app->getContainer()));
    $app->post('/login', [LoginController::class, 'checkLogin']);
    $app->post('/register', [RegisterController::class, 'checkValidate']);
};
