<?php

use DI\ContainerBuilder as ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$database = require __DIR__ . '/database.php';
$database($containerBuilder);

return $containerBuilder ->build();
