<?php

use DI\Container;

return function (Container $container) {
    $config = [
        'driver' => 'pgsql',
        'host' => 'database',
        'database' => 'testing',
        'username' => 'application',
        'password' => 'password',
        'port' => 5432,
        'charset' => 'utf8',
    ];

    $container->set('db', $config);
};
