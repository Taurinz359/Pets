<?php

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Views\Twig;

class LoginMiddleware
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if ($this->isLoginUser($request->getCookieParams())) {
            $response = $handler->handle($request);
            return $response->withStatus(301, 'IsLogin')->withHeader('Location', '/posts')->withHeader("Cache-Control", 'no-cache, no-store, must-revalidate')->withHeader('Pragma', 'no-cache')->withHeader('Expires', '0');
        }
        $response = $handler->handle($request);
        return $response->withHeader("Cache-Control", 'no-cache, no-store, must-revalidate')->withHeader('Pragma', 'no-cache')->withHeader('Expires', '0');
    }

    public function isLoginUser(array $requsetData)
    {
        return !empty($requsetData[md5('TestToken')]);
    }
}
