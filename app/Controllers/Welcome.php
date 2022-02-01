<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class Welcome
{
    public function showWelcome(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response, 'welcome.twig');
    }
}
