<?php

namespace Tests;

use Dotenv\Dotenv;

use function DI\get;

class HomePageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->refreshDatabase();
    }

    public function test_home_rout_without_cookie()
    {
        $request = $this->createRequest('GET', '/home');
        $response = $this->app->handle($request);
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function test_home_rout_with_cookie()
    {
        $cookieValue = implode(md5('bottle'), [
            1 => '6',
            2 => '$2y$10$Xyt7o0Yj5l5bVUZGAG9dFOxTysAkWj'
        ]);
        $request = $this->createRequest(
            'GET',
            '/home',
            ['HTTP_ACCEPT' => 'application/json'],
            [md5('TestToken') => $cookieValue]
        );
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
