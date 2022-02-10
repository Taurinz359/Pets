<?php

namespace App\Middleware;

use App\Auth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RegisterMiddleware
{
    private ContainerInterface $container;
    private Auth $auth;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $response = $this->deleteToken($request, $response);
        return $response->withHeader('Location', '/login');
    }

    private function deleteToken(Request $request, Response $response)
    {
        $this->auth = $this->container->get(Auth::class);
        if ($this->auth->checkToken($request, $response)) {
            $cookie = md5('TestToken') . '=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; Max-Age=0;';
            return $response->withHeader('Set-Cookie', $cookie);
        }
        return $response;
    }
}
