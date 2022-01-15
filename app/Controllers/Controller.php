<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

class Controller
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container=$container;
        var_dump($container);
        die;
    }
}