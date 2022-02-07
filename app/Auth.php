<?php

namespace App;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Auth
{
    protected $container;
    private $user;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function attempt(): bool
    {
        // setcookie()
    }

    public function checkToken(Request $request, RequestHandler $handler): bool
    {
        if ($this->validateToken($request)) {
            return true;
        }
        return false;
        // $_COOKIE['token']
        // validateToken()
        // set current auth user
        // return true
        // setcookie('token', null, -1);
    }

    private function validateToken(Request $request)
    {
        if(!empty($request->getCookieParams()[md5('TestToken')])){
            $cookie = $request->getCookieParams()[md5('TestToken')];
            $cookieValues = explode(md5("bottle"),$cookie,2);
            var_dump($cookieValues);
            return true;
        }
        return false;
    }
}
