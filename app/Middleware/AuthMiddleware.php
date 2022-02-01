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
     * @return string Route
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */

    private function isValidateUser(): string
    {
        $this->auth = $this->container->get(Auth::class);
        if ($this->auth->checkToken()) {
            return "/home";
        }
        return "/";
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $route = $this->isValidateUser();
        $response = $handler->handle($request);
        return $response->withHeader('Location', '/login');
    }
}
