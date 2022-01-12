<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
//        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql',
            'host' => 'localhost',
            'name' => 'postgres',
            'user' => 'application',
            'pass' => 'password',
            'port' => 8033,
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
