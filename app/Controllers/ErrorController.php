<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class ErrorController extends Controller
{
    public function showError(Request $request, Response $response,)
    {
        return Twig::fromRequest($request)->render($response,'error.twig');
    }
}