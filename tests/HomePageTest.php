<?php

namespace Tests;

use App\Models\User;
use Slim\App;

class HomePageTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->refreshDatabase();
    }


    public function test_post()
    {
        $request = $this->createRequest('POST', '/register')
            ->withParsedBody([
                'email'=>'email@tres.ru',
                'password' => '1234',
                'password-check'=> '1234'
            ]);

        $response = $this->app->handle($request);



        $this->assertStringNotContainsString('В глаза долбишься?', (string)$response->getBody());
    }

}