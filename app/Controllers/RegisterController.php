<?php

namespace App\Controllers;

use App\Validation\Validator;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Respect\Validation\Validator as v;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class RegisterController extends Controller
{
    function checkValidate(Request $request, Response $response): ResponseInterface
    {
        $validator = $this->getValidator();
        $requestData = $request->getParsedBody();
        $validator->validate($requestData, [
            'email' => v::email()->setTemplate('Ты че хуила? Ты че удумал:?'),
            'password' =>  v::length(3, 30),
            'password-check' => v::length(3, 30)->equals($requestData['password'])->setTemplate('В глаза долбишься?'),
        ]);
//        if($validator->hasFailed()){
            return Twig::fromRequest($request)->render(
                $response,
                'register.twig',
                ['errors' => $validator->getErrors()]
            );
//        }
    }
}