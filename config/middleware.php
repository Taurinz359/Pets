<?php

use Slim\App;
use Slim\Views\Twig as TwigAlias;
use Slim\Views\TwigMiddleware as TwigMiddlewareAlias;
use Slim\Middleware\MethodOverrideMiddleware;

return static function (App $app) {
    $twig = TwigAlias::create(__DIR__ . '/../templates', ['cache' => false,'debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $app->addRoutingMiddleware();
    $app->add(new MethodOverrideMiddleware());
    $app->add(TwigMiddlewareAlias::create($app, $twig));
    $app->addErrorMiddleware(true, true, true);
};
