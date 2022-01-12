<?php

namespace App\Controllers;

use App\Models\Users;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController
{
    public function index(Request $request, Response $response, $args): Response
    {
        return Twig::fromRequest($request)->render($response, 'index.twig',
            ['user' => Users::first()?->toArray()]
        );

    }
}