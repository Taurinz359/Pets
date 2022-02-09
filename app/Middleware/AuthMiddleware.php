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
        $response = $handler->handle($request);
        if ($this->auth->checkToken($request, $response)) {
            return $response->withStatus(200);
        }
        return $response->withHeader('Location', '/')->withStatus(301);
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        return $this->isValidateUser($request, $handler);
    }

}
