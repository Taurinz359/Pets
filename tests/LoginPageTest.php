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
}
