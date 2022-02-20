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
            $response = $this->auth->attempt($userData, $request, $response);
            return $this->isSuccessLogin($response, $request, true);
        }
        return $this->isSuccessLogin($response, $request);
//        todo request to auth
    }

    protected function isSuccessLogin(Response $response, Request $request, bool $success = false)
    {
        if ($success) {
            return $response->withStatus(200, 'successful login')->withHeader('Location', 'home');
        }
        return Twig::fromRequest($request)->render(
            $response->withStatus(400, 'incorrect user'),
            'login.twig',
            ['errors' => ['email' => [0 => 'Логин или пароль введён некорректно']]]
        );
    }
}
