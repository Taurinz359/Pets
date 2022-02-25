<?php

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LogoutController extends Controller
{
    public function logout(Request $request, Response $response)
    {
        $cookie = md5('TestToken') . '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; Max-Age=0;';
        return $response->withHeader('Set-Cookie',$cookie)->withStatus(302)->withHeader('Location', '/posts');
    }
}