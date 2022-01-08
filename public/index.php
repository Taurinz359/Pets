<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

$app = AppFactory::create();

$app->add(function (Request $request, RequestHandler $handler){
    return$handler->handle($request);
});
//$app->addErrorMiddleware(false,false,true);
//
//$app ->get('/', [HomeController::class, 'preview']);

$app->run();