<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;


class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler ): Response
    {
        $response = $handler->handle($request);
        var_dump($_COOKIE);
        return $response->withHeader('Set-Cookie', $this->checkCookie());
    }

    private function checkCookie():string
    {
        return "Empty";
    }
}