<?php

namespace App\Controllers;

use App\Auth;
use App\Middleware\AuthMiddleware;
use App\Models\User;
use Psr\Container\ContainerInterface;
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
        $userData = User::where('email', $requestData['email'])->first();
        if (!empty($userData) && password_verify($requestData['password'], $userData->password)) {
            $this->auth->attempt($userData, $request);
            return $this->isSuccessLogin($response, true);
        }
        return $this->isSuccessLogin($response, false);
//        todo request to auth
    }

    protected function isSuccessLogin(Response $response, bool $success = false)
    {
        if ($success) {
            return $response->withStatus(200, 'successful login')->withHeader('Location', 'home');
        }
        return $response->withStatus(400, 'unsuccessful login')->withHeader('Location', 'login');
    }
}
