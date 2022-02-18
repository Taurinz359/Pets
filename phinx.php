<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'production',
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'database',
            'name' => 'application',
            'user' => 'application',
            'pass' => 'password',
            'port' => '5432',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => 'database',
            'name' => 'testing',
            'user' => 'application',
            'pass' => 'password',
            'port' => '5432',
            'charset' => 'utf8',

        ]
    ],
    'version_order' => 'creation'
];
