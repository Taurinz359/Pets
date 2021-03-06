<?php

namespace Tests;

use function DI\string;

class RegisterPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }
    public function test_post()
    {
        $request = $this->createRequest('POST', '/register')
            ->withParsedBody([
                'email' => 'email@tres.ru',
                'password' => '1234',
                'password-check' => '1234'
            ]);
        $response = $this->app->handle($request);
        $this->assertStringNotContainsString('В глаза долбишься?', (string)$response->getBody());
        $this->assertStringContainsString('/login', $response->getHeaders()['Location'][0]);
        $dbTable = new UserTest();
        $user = $dbTable::select('*')->where('id', '=', 6)->get()->toArray();
        $this->assertNotEmpty($user);
    }

    public function test_errors_register_route()
    {
        $request = $this->createRequest('POST', '/register')
            ->withParsedBody([
                'password' => '134',
                'password-check' => '1234'
            ]);
        $response = $this->app->handle($request);
        $this->assertStringContainsString('В глаза долбишься?', (string)$response->getBody());
        $this->assertEmpty($response->getHeaders());
        $dbTable = new UserTest();
        $user = $dbTable::select('*')->where('id', '=', 11)->get()->toArray();
        $this->assertEmpty($user);
    }

    public function test_route()
    {
        $request = $this ->createRequest('GET', '/');
        $response = $this->app->handle($request);
        $this->assertStringContainsString('/posts', $response->getHeaders()['Location'][0]);
    }
}
