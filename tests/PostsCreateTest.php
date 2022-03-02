<?php

namespace Tests;

use App\Models\User;
use Faker\Factory;
use Faker\Provider\Text;

class PostsCreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function test_get_posts_route(): void
    {
        $request = $this->createRequest('GET', '/posts');
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_create_route_without_cookie(): void
    {
        $request = $this->createRequest('GET', '/posts/create');
        $response = $this->app->handle($request);
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function test_create_route_with_cookie()
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
            '/posts/create',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        );
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_post_posts_route_without_cookie()
    {
        $request = $this->createRequest('POST', '/posts');
        $response = $this->app->handle($request);
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function test_post_posts_route_with_cookie()
    {
        $cookie = implode(
            md5("bottle"),
            [
                $this->user->id,
                $this->user->password
            ]
        );
        $request = $this->createRequest(
            'POST',
            '/posts',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        );
        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_save_post_in_db()
    {
        $faker = Factory::create();
        $cookie = implode(
            md5("bottle"),
            [
                $this->user->id,
                $this->user->password
            ]
        );
        $request = $this->createRequest(
            'POST',
            '/posts',
            ['HTTP_ACCEPT' => 'application/json'],
            ["ce3186f2076d58949b78858d244c3efe" => $cookie]
        )->withParsedBody([
            'name' => $faker->realText(10),
            'content' => $faker->realtext(100),
        ]);

        $response = $this->app->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
