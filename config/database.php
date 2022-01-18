<?php

use DI\Container as Container;

return function (Container $container) {
    $config = [
        'driver' => 'pgsql',
        'host' => 'database',
        'database' => 'application',
        'username' => 'application',
        'password' => 'password',
        'port' => 5432,
        'charset' => 'utf8',
    ];

    $container->set('db',$config);
};
