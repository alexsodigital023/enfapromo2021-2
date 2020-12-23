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
];
