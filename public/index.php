<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

$app = AppFactory::create();

$middleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    false,
    false,
    false
);
$app->add($middleware);

$app ->get('/', function (Request $request, Response $response, $args){
    $response->getBody()->write("Hello world!");
//
    return $response;
});

$app->run();