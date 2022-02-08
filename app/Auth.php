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
            var_dump($cookie);

            $cookieValues = explode(md5("bottle"),$cookie,2);
            var_dump($cookieValues);
            $db = User::find(6);
            var_dump($db->password);

            /*todo
                Сравниваем юзера с бд. Нам нужен хэш айди и хэш пасса
                можно попробовать прогнать в цикле
                setcookie('token', null, -1);
                Если с куки  какие то проблемы или нет такого юзера в бд -> удалить куки.
            */
            return true;
        }
        return false;

    }
}
