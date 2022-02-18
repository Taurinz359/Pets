<?php

use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\Posts;
use App\Controllers\RegisterController as RegisterController;
use App\Controllers\Welcome;
use App\Middleware\AuthMiddleware;
use App\Middleware\RegisterMiddleware;
use Slim\App;

return static function (App $app) {
    $app->redirect('/','/posts');
    $app->get('/login', [LoginController::class, 'showLogin']);
    $app->post('/login', [LoginController::class, 'checkLogin']);
    $app->get('/posts', [Posts::class,'showPosts']);


    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->post('/register', [RegisterController::class, 'checkValidate'])->add(new  RegisterMiddleware($app->getContainer()));
    $app->get('/home', [HomeController::class, 'index'])->add(new AuthMiddleware($app->getContainer()));
};
