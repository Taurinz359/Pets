<?php

namespace App\Controllers;

use App\Validation\Validator;
use Psr\Container\ContainerInterface;

class Controller
{
    protected ContainerInterface $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }

    protected function getValidator(): Validator
    {
        return $this->container->get(Validator::class);
    }

}