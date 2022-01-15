<?php

use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use Slim\App;

return function (App $app) {
    $app->redirect('/', '/register', 301);
    $app->get('/register', HomeController::class . ':index');
    $app->post('/register',[RegisterController::class, 'checkEmail']);
    $app->get('/home', [RegisterController::class, 'test']);
};

