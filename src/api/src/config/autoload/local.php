<?php
return [
    'api-tools-mvc-auth' => [
        'authentication' => [
            'adapters' => [
                'basic' => [
                    'adapter' => \Laminas\ApiTools\MvcAuth\Authentication\HttpAdapter::class,
                    'options' => [
                        'accept_schemes' => [
                            0 => 'basic',
                        ],
                        'realm' => 'api',
                        'htpasswd' => 'data/users.htpasswd',
                    ],
                ],
            ],
        ],
    ],
];
