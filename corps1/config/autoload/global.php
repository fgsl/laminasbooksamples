<?php
return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=corps;hostname=localhost',
    ],
    'service_manager' => [
        'factories' => [
            'LaminasDbAdapter'
            => 'Laminas\Db\Adapter\AdapterServiceFactory',
        ],
    ],
];

