<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class NewUser
{
    public function checkEmail(Request $request,Response $response){
        return Twig::fromRequest($request) ->render(
            $response,
            'home.twig',
            ['user' => $request->getParsedBody()]
        );
    }

}