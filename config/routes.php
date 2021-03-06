<?php

use App\Controllers\ErrorController;
use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\LogoutController;
use App\Controllers\PostsController;
use App\Controllers\RegisterController as RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Middleware\DeleteTokenMiddleware;
use App\Middleware\LoginMiddleware;
use Slim\App;

return static function (App $app) {
    $app->redirect('/', '/posts');

    $app->get('/posts', [PostsController::class,'showPosts']);
    $app->get('/login', [LoginController::class, 'showLogin'])->add(new LoginMiddleware($app->getContainer()));
    $app->get('/posts/create', [PostsController::class, 'showCreateForm'])->add(new AuthMiddleware($app->getContainer()));
    $app->get('/post/{id}', [PostsController::class, 'showPost']);
    $app->get('/logout', [LogoutController::class,'logout']);
    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->get('/home', [HomeController::class, 'showHome'])->add(new AuthMiddleware($app->getContainer()));
    $app->get('/post/{id}/edit', [PostsController::class, 'showEditPost'])->add(new AuthMiddleware($app->getContainer()));

    $app->get('/error', [ErrorController::class, 'showError']);

    $app->post('/posts', [PostsController::class, 'createPost'])->add(new AuthMiddleware($app->getContainer()));
    $app->post('/login', [LoginController::class, 'checkLogin'])->add(new LoginMiddleware($app->getContainer()));
    $app->post('/register', [RegisterController::class, 'checkValidate']);

    $app->delete('/post/{id}', [PostsController::class, 'deletePost'])->add(new AuthMiddleware($app->getContainer()));
    $app->put('/post/{id}', [PostsController::class,'editPost'])->add(new AuthMiddleware($app->getContainer()));
};
