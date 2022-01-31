<?php

use Slim\App;
use Slim\Views\Twig as TwigAlias;
use Slim\Views\TwigMiddleware as TwigMiddlewareAlias;

return static function (App $app) {
    $twig = TwigAlias::create(__DIR__ . '/../templates', ['cache' => false,'debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $app->add(TwigMiddlewareAlias::create($app, $twig));
    $app->addErrorMiddleware(true, true, true);

};
