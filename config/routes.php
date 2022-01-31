<?php

use App\Controllers\HomeController;
use App\Auth\AuthController;
use App\Controllers\RegisterController as RegisterController;
use App\Controllers\Welcome;
use Slim\App;

return static function (App $app) {
    $app->get('/', [Welcome::class, 'showWelcome']);
    $app->get('/login', [AuthController::class, 'showLogin']);
    $app->post('/login', [AuthController::class, 'checkLogin']);

    $app->get('/register', [RegisterController::class, 'showRegister']);
    $app->post('/register', [RegisterController::class, 'checkValidate']);
    $app->get('/home', [HomeController::class, 'index']);
};
