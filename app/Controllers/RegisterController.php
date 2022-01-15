<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

class RegisterController
{
    private array $_valid = [
        'emailValid' => "is-invalid",
        'emailValidMessage' => "It isn't email",
        'passValid' => "is-invalid",
        'passInvalidMessage' => "Password is incorrect",
        'rout' => "/home"
    ];

    public function checkEmail(Request $request, Response $response): Response
    {
        $container = require __DIR__ . '/../Validation/Validator.php';

        $check = true;
        if (true === $check) {
            return  $response->withHeader('Location' ,'/home', )->withStatus(302);
        }
        return Twig::fromRequest($request)->render(
            $response,
            'home.twig',
            ['user' => $request->getParsedBody(), 'valid' => $this->_valid
            ]
        );
    }

    public function test(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render(
            $response,
            'home.twig',
            ['user' => $request->getParsedBody(), 'valid' => $this->_valid
            ]
        );
    }
}