<?php

use Slim\App;
use Slim\Views\Twig as TwigAlias;
use Slim\Views\TwigMiddleware as TwigMiddlewareAlias;

return function (App $app) {
    $twig = TwigAlias::create(__DIR__ . '/../templates', ['cache' => false]);
    $app->add(TwigMiddlewareAlias::create($app, $twig));
};
