<?php

namespace App;

use App\Models\User;
use Psr\Container\ContainerInterface;

class Auth
{
    protected $container;
    private $user;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    function attempt(): bool
    {
        // setcookie()
    }

    function checkToken()
    {
        var_dump($_COOKIE['lol']);

// $_COOKIE['token']
// validateToken()
// set current auth user
// return true
// setcookie('token', null, -1);
    }
}
