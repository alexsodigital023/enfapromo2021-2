<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => 'Pdo_Mysql',
                'database' => 'prueba',
                'username' => 'prueba',
                'password' => 'prueba',
                'hostname' => 'db',
                'port' => '3306',
            ],
        ],
    ],
    'cdp' =>[
        'client_id'=>'md-so-digital-stage',
        'client_secret'=>'R5k{8JX_$Zh',
        'basic_auth'=>'reckittbenckiser:t8uLkZMWNa87mxzKokKCXVQ9PEkwzXJv9YrHRD7r63WJwh5djf',
        'baseurl'=>'https://digital-security-authservice-regression.frankfurt.rbdigitalcloud.com',
        'apiurl'=>'https://api.cdp-rb.com'
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
                'operator\\V1' => 'basic',
                'ping\\V1' => 'oauth',
            ],
        ],
    ],
];
