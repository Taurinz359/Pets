<?php

namespace Tests;

use App\Models\User;
use Dotenv\Dotenv;

use function DI\get;

class HomePageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
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
        $cookie = implode(
            md5("bottle"),
            [
                $this->user->id,
                $this->user->password
            ]
        );
        $request = $this->createRequest(
            'GET',
            '/home',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        );

        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
