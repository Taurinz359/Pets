<?php

return
[
    'paths' => [
        'migrations' => '/db/migrations',
        'seeds' => '/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
//        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'database',
            'name' => 'application',
            'user' => 'application',
            'pass' => 'password',
            'port' => 5432,
            'charset' => 'utf8',
        ],
        'testing'=>[
            'adapter' => 'sqlite',
            'name' => 'testing',
            'charset' => 'utf8'
        ]
    ],
    'version_order' => 'creation'
];
