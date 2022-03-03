<?php

namespace App\Middleware;

use App\Auth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware
{
    private ContainerInterface $container;
    private Auth $auth;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */

    private function isValidateUser(Request $request, RequestHandler $handler): Response
    {
        $this->auth = $this->container->get(Auth::class);

        if ($this->auth->checkToken($request)) {
            $response = $handler->handle($request);
            return $response->withStatus(200);
        }


        $cookie = md5('TestToken') . '=deleted; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; Max-Age=0;';
        $response = new \Slim\Psr7\Response();
        return $response->withHeader('Location', '/error')->
        withHeader('Set-Cookie', $cookie)->
        withStatus(301);
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        return $this->isValidateUser($request, $handler);
    }
}
