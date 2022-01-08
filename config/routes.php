<?php

use App\Controllers\HomeController as HomeController;
use Slim\App;

return function (App $app){
    $app->get('/',[HomeController::class,'index']);
};