<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => \Mysqli::class,
                'database' => 'prueba',
                'username' => 'prueba',
                'password' => 'prueba',
                'hostname' => 'db',
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
    'storage' => [
        'adapters' =>[
            'do_spaces' =>[
                'driver' => Aws\S3\S3Client::class,
                'version' => 'latest',
                'region'  => 'NYC3',
                'endpoint' => 'https://nyc3.digitaloceanspaces.com',
                'credentials' => [
                        'key'    => 'M4I2LYAQVWAXFGF5W5XJ',
                        'secret' => 'd+okr4VB3gZNPuwV0ubV34G6mxonCzbsTvxIRM3qSZk',
                    ],
                'bucket' => 'imatch'
            ]
        ]
    ]
];
