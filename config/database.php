<?php

return function (\DI\ContainerBuilder $builder) {
    $config = [
        'driver' => 'pgsql',
        'host' => 'database',
        'database' => 'application',
        'username' => 'application',
        'password' => 'password',
        'port' => 5432,
        'charset' => 'utf8',
    ];

    $builder->addDefinitions(['db' => $config]);
};
