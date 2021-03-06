<?php

namespace Tests;

use App\Models\Post;
use Faker\Factory;

class PostsPageTest extends TestCase
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

    public function test_post_posts_route_with_empty_body()
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
        $this->assertEquals('/error', $response->getHeaders()['Location'][0]);
        $this->assertEquals(200, $response->getStatusCode());
    }


    public function test_post_posts_route_with_cookie()
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
            'name' => $faker->realText(100),
            'content' => $faker->realtext(1000),
        ]);
        $response = $this->app->handle($request);
        $lastRecordInDb = Post::latest('id')->first()->toArray()['status'];
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(8, Post::all()->count());
        $this->assertEquals(2, $lastRecordInDb);
    }

    public function test_post_posts_route_with_cookie_draft()
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
            'name' => $faker->realText(100, 5),
            'content' => $faker->realtext(1000, 2),
            'draft' => 'true'
        ]);
        $response = $this->app->handle($request);
        $lastRecordInDb = Post::latest('id')->first()->toArray()['status'];
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(8, Post::all()->count());
        $this->assertEquals(1, $lastRecordInDb);
    }
    public function test_post_posts_with_incorrect_data()
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
            'name' => ',',
            'content' => '123',
            'draft' => 'true'
        ]);
        $response = $this->app->handle($request);
        $this->assertStringContainsString('Needs more', (string) $response->getBody());
    }
}
