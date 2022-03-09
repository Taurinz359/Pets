<?php

namespace Tests;

use App\Models\User;
use Illuminate\Database\Capsule\Manager;
use Phinx\Config\Config;
use Phinx\Console\PhinxApplication;
use Phinx\Wrapper\TextWrapper;
use PHPUnit\Framework\TestCase as PHPUnit;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class TestCase extends phpUnit
{
    protected App $app;
    protected User $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->app = $this->getAppInstance();
    }

    protected function refreshDatabase(): void
    {
        exec('cd /app && vendor/bin/phinx rollback -e testing');
        exec("cd /app && vendor/bin/phinx migrate -e testing");
        exec("cd /app && vendor/bin/phinx seed:run -e testing");
        $this->user = User::find(6);
    }

    protected function getAppInstance(): App
    {
        $container = require __DIR__ . '/TestBootstrap.php';

        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $routes = require __DIR__ . '/../config/routes.php';
        $routes($app);

        $middleware = require __DIR__ . '/../config/middleware.php';
        $middleware($app);

        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection($container->get('db'));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $app;
    }

    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }
        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }

    protected function tearDown(): void
    {
        exec('cd /app && vendor/bin/phinx rollback -e testing');
        parent::tearDown();
    }
}
