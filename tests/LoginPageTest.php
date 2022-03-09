<?php

namespace Tests;

class LoginPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function test_login_data(): void
    {
        $request = $this->createRequest('POST', '/login') ->withParsedBody(
            [
                'email' => 'admin@area.ru',
                'password' => 'hashcode'
            ]
        );
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_failed_login_data(): void
    {
        $request = $this->createRequest('POST', '/login')->withParsedBody(
            [
                'email' => 'admdsadsin@area.ru',
                'password' => 'hashcdsdsode'
            ]
        );
        $response = $this->app->handle($request);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_get_login_route_have_cookie()
    {
        $cookie = implode(
            md5("bottle"),
            [
                $this->user->id,
                $this->user->password
            ]
        );
        $request = $this->createRequest(
            'GET',
            '/login',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        );
        $respone = $this->app->handle($request);
        $this->assertEquals(301, $respone->getStatusCode());
    }

    public function test_post_login_route_have_cookie()
    {
        $cookie = implode(
            md5("bottle"),
            [
                $this->user->id,
                $this->user->password
            ]
        );
        $request = $this->createRequest(
            'GET',
            '/login',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        );
        $respone = $this->app->handle($request);
        $this->assertEquals(301, $respone->getStatusCode());
    }
}
