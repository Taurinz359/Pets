<?php

namespace App\Controllers;

use App\Auth;
use App\Validation\Validator;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $validator;
    protected Auth $auth;
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->validator = $this->container->get(Validator::class);
        $this->auth = $this->container->get(Auth::class);
    }

//    public function getValidator(): Validator
//    {
//        return $this->container->get(Validator::class);
//    }
}
