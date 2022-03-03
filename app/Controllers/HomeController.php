<?php

namespace App\Controllers;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class HomeController extends Controller
{
    public function showHome(Request $request, Response $response): Response
    {
        $user = $this->container->get('auth_user');
        $posts = $user->posts->toArray();
        return Twig::fromRequest($request)->render(
            $response,
            'home.twig',
            ['posts' => $posts]
        );
    }
}
