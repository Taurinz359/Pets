<?php

namespace App;


use Psr\Container\ContainerInterface;

class Auth
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    function attempt() : bool
    {

    }

    function checkToken()
    {

    }
}