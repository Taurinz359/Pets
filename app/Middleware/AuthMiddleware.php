<?php

namespace App\Middleware;


use Slim\App;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthMiddleware
{
    protected Response $responce;
    protected Request $request;

    public function __invoke(Request $request, Response $response): Response
    {
        var_dump('middleware');
    }
}