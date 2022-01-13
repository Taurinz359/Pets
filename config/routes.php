<?php

use App\Controllers\NewUser;
use Slim\App;
use App\Controllers\HomeController;

return function (App $app) {
    $app->get('/', [HomeController::class,'index']);
    $app->post('/home',[NewUser::class, 'checkEmail']);
};
