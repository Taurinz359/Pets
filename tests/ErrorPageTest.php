<?php

namespace Tests;

use function DI\string;

class ErrorPageTest extends TestCase
{
    public function test_incorrect_route()
    {
        $request = $this->createRequest('GET', '/error');
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Error',(string)$response->getBody());
    }
}