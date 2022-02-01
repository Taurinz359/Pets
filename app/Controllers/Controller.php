<?php

namespace App\Controllers;

use App\Validation\Validator;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $validator;

    protected ContainerInterface $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->validator = $this->container->get(Validator::class);
    }

//    public function getValidator(): Validator
//    {
//        return $this->container->get(Validator::class);
//    }
}
