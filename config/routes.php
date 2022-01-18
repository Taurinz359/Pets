<?php

use App\Controllers\HomeController;
use App\Controllers\RegisterController as RegisterController;
use Slim\App;

return static function (App $app) {
    $app->redirect('/', '/register', 301);
    $app->get('/register', [HomeController::class , 'index']);
    $app->post('/register',[RegisterController::class, 'checkValidate']);
//    $app->get('/home', [RegisterController::class, 'test']);
};

