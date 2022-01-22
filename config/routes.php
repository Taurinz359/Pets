<?php

use App\Controllers\HomeController;
use App\Controllers\RegisterController as RegisterController;
use App\Controllers\Welcome;
use Slim\App;

return static function (App $app) {
    $app->get('/', [Welcome::class, 'showWelcome']);
    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->post('/register', [RegisterController::class, 'checkValidate']);
    $app->get('/home', [HomeController::class, 'index']);
};
