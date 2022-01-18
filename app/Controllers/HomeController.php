<?php

namespace App\Controllers;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController extends Controller
{
    public function index(Request $request,Response $response): Response
    {
        return Twig::fromRequest($request)->render(
            $response,
            'register.twig',
//            ['user' => User::first()?->toArray()]
        );
    }
}