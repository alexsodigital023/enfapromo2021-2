<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    // 'db' => [
    //     'adapters' => [
    //         'database' => [
    //             'driver' => 'Pdo_Mysql',
    //             'database' => 'chocomilk',
    //             'username' => 'doadmin',
    //             'password' => 'cperj0r7ng3hl9ld',
    //             'hostname' => 'db-mysql-nyc1-42577-do-user-1684304-0.b.db.ondigitalocean.com',
    //             'port' => '25060'
    //         ],
    //     ],
    // ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => 'Pdo_Mysql',
                'database' => 'prueba',
                'username' => 'root',
                'password' => 'prueba',
                'hostname' => 'db',
                'port' => '3306'
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type' => 'regex',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'operator\\V1' => 'oauth',
                'ping\\V1' => 'oauth',
            ],
        ],
    ],
];
