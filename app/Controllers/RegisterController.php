<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class RegisterController extends Controller
{
    public function showRegister(Request $request, Response $response): ResponseInterface
    {
        return Twig::fromRequest($request)->render($response,'register.twig');
    }

    public function checkValidate(Request $request, Response $response): ResponseInterface
    {
        $requestData = $request->getParsedBody();
        $this->validator->validate($requestData, [
            'email' => v::email()->setTemplate('Ты че хуила? Ты че удумал:?'),
            'password' => v::length(3, 30),
            'password-check' => v::length(3, 30)->equals($requestData['password'])->setTemplate('В глаза долбишься?'),
        ]);
        return $this->getTemplate($request,$response);
    }


    protected function getTemplate(Request $request, Response $response): Response|\Slim\Psr7\Message|ResponseInterface
    {
        if($this->validator->getErrors()){
            return Twig::fromRequest($request)->render(
                $response,
                'register.twig',
                ['errors' => $this->validator->getErrors()]
            );
        }
        return $response->withStatus(302)->withHeader('Location','/home');
    }
}