<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController
{

    public function index(Request $request, Response $response, $args): Response
    {
        return Twig::fromRequest($request)->render(
            $response,
            'registry.twig',
            ['user' => User::first()?->toArray()]
        );

    }
}