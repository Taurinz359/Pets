<?php

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class RegisterController extends Controller
{
    public function showRegister(Request $request, Response $response): ResponseInterface
    {
        return Twig::fromRequest($request)->render($response, 'register.twig');
    }

    public function checkValidate(Request $request, Response $response): ResponseInterface
    {
        $requestData = $request->getParsedBody();
        $pass = array_key_exists('password', $requestData) ? $requestData['password'] : null;
        $this->validator->validate($requestData, [
            'email' => v::email()->setTemplate('Ты че хуила? Ты че удумал:?'),
            'password' => v::notEmpty()->length(3, 30),
            'password-check' => v::notEmpty()->length(3, 30)->equals($pass)->setTemplate('В глаза долбишься?'),
        ]);
        return $this->getTemplate($request, $response);
    }

    protected function getTemplate(Request $request, Response $response): Response|\Slim\Psr7\Message|ResponseInterface
    {
        if ($this->validator->getErrors()) {
            return Twig::fromRequest($request)->render(
                $response,
                'register.twig',
                ['errors' => $this->validator->getErrors()]
            );
        } elseif ($this->isUniqEmailInDb($request->getParsedBody())) {
            return Twig::fromRequest($request)->render(
                $response,
                'register.twig',
                ['errors' => ['email' => [0 => 'Такой Email уже сущетсвует']]]
            );
        }
        $response = $this->deleteToken($request,$response);
        $this->registerUser($request->getParsedBody());
        return $response->withStatus(302)->withHeader('Location', '/home');
    }

    private function isUniqEmailInDb($requestData): bool
    {
        $userData = User::where('email', $requestData['email'])->first();
        return (!empty($userData));
    }

    private function registerUser(array $request)
    {
        $newUser = User::create([
            'email' => $request['email'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT)
        ]);
        $newUser->save();
    }

    private function deleteToken(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response)
    {
        $this->auth = $this->container->get(Auth::class);
        if ($this->auth->checkToken($request, $response)) {
            $cookie = md5('TestToken') . '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; Max-Age=0;';
            return $response->withHeader('Set-Cookie', $cookie);
        }
        return $response;
    }
}
