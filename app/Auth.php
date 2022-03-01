<?php

namespace App;

use App\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use function DI\get;

class Auth
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function attempt($userData, Request $request, Response $response)
    {
        if (!$this->checkToken($request, $response)) {
            $cookie = md5('TestToken') . '=' .
                implode(md5('bottle'), [
                    1 => $userData->id,
                    2 => $userData->password
                ]);
            return $response->withHeader('Set-Cookie', $cookie);
        }
        return $response;
    }


    public function checkToken(Request $request, Response $response): bool
    {

        if (empty($request->getCookieParams()[md5('TestToken')])) {
            return false;
        }
        $cookie = $request->getCookieParams()[md5('TestToken')];
        $cookieValues = explode(md5("bottle"), $cookie, 2);
        if (empty($cookieValues)) {
            return false;
        }
        $user = User::find($cookieValues[0]);
        if (empty($user) || $cookieValues[1] !== $user->password) {
            return false;
        }

        return true;
    }
}
