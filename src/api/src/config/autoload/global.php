<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'database' => [
                'driver' => 'Pdo_Mysql',
                'database' => 'prueba',//chocomilk
                'username' => 'root',//doadmin
                'password' => 'prueba',//cperj0r7ng3hl9ld
                'hostname' => 'db',//db-mysql-nyc1-42577-do-user-1684304-0.b.db.ondigitalocean.com
                'port' => '3306'
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
                'operator\\V1' => 'oauth',
                'ping\\V1' => 'oauth',
            ],
        ],
    ],
];
