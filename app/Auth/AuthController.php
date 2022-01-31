<?php

namespace App\Auth;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class AuthController
{
    protected ContainerInterface $container;

    public function showLogin(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response, 'login.twig');
    }

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }

    public function checkLogin(Request $request, Response $response)
    {

        $requestData = $request->getParsedBody();
        return $this->successLogin($response);
    }

    protected function successLogin(Response $response)
    {
        return $response->withStatus(200,'successful login')->withHeader('Location','home');
    }
}