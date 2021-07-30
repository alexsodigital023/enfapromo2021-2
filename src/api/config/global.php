<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => \Mysqli::class,
                'database' => 'defaultdb',
                'username' => 'doadmin',
                'password' => 'tm0m4rm7oukqeuqz',
                'hostname' => 'db-mysql-nyc3-83436-enfapromo2021-2-do-user-1684304-0.b.db.ondigitalocean.com',
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
                        'key'    => '2BY5UOXMGVA62RZTXESU',
                        'secret' => 'aPxjjt1T9Qs/shyHXdGNDuRZsxUooPmMPqU0XrEpu+M',
                    ],
                'bucket' => 'chocomilk'
            ]
        ]
    ]
];
