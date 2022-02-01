<?php

namespace App;

use Psr\Container\ContainerInterface;

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

    public function checkToken(): bool
    {
        var_dump($_COOKIE['lol']);
        if ($this->validateToken()) {
            return true;
        }
        return false;
        // $_COOKIE['token']
        // validateToken()
        // set current auth user
        // return true
        // setcookie('token', null, -1);
    }

    private function validateToken()
    {
        if ($_COOKIE[md5('TestToken')]) {
            return true;
        }
        return false;
    }
}
