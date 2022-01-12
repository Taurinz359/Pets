<?php

return function (\DI\ContainerBuilder $builder) {
    $config = [
        'driver' => 'pgsql',
        'host' => 'localhost',
        'database' => 'postgres',
        'username' => 'application',
        'password' => 'password',
        'port' => 8033,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ];

    $builder->addDefinitions(['db' => $config]);
};
