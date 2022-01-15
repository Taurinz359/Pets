<?php

namespace App\Controllers;

use App\Models\User;
use Cake\Core\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController extends Controller
{
    public function index(): Response
    {
//        return Twig::fromRequest($request)->render(
//            $response,
//            'register.twig',
//            ['user' => User::first()?->toArray()
//            ]
//        );
    }
}