<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class LoginController extends Controller
{
    public function showLogin(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response, 'login.twig');
    }


    public function checkLogin(Request $request, Response $response)
    {
        $requestData = $request->getParsedBody();
//        todo request to auth
    }

    protected function IsSuccessLogin(Response $response, bool $success = false)
    {
        if ($success) {
            return $response->withStatus(200, 'successful login')->withHeader('Location', 'home');
        }
        return $response->withStatus(400, 'unsuccessful login')->withHeader('Location', 'login');
    }
}
