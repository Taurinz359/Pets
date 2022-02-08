<?php

namespace App;

use App\Models\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use function DI\get;

class Auth
{
    protected $container;
    private $user;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function attempt(): bool
    {
        // setcookie()

    }

    public function checkToken(Request $request, RequestHandler $handler): bool
    {
        if ($this->validateToken($request)) {
            return true;
        }
        return false;
        // $_COOKIE['token']
        // validateToken()
        // set current auth user
        // return true

    }

    private function validateToken(Request $request)
    {
        if(!empty($request->getCookieParams()[md5('TestToken')])){
            $cookie = $request->getCookieParams()[md5('TestToken')];
            $cookieValues = explode(md5("bottle"),$cookie,2);
            $user = User::find($cookieValues[0]);
            if ($user !== null && $cookieValues[1] === $user->password)
                return true;
            elseif ($user !== null && $cookieValues[1] !== $user->password)
                setcookie(md5('TestToken') ,'',-1);
        }
        return false;
    }
}
