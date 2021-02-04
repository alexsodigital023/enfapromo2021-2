<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => \Mysqli::class,
                'database' => 'golden',
                'username' => 'golden',
                'password' => '3XRMws3hKmbvPCsTf4jT9nPnd',
                'hostname' => 'ec2-18-222-32-38.us-east-2.compute.amazonaws.com',
                'port' => '25060'
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
