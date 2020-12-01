<?php
return [
    'service_manager' => [
        'factories' => [
            \ping\V1\Rest\Ping\PingResource::class => \ping\V1\Rest\Ping\PingResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'ping.rest.ping' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ping[/:ping_id]',
                    'defaults' => [
                        'controller' => 'ping\\V1\\Rest\\Ping\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'ping.rest.ping',
        ],
    ],
    'api-tools-rest' => [
        'ping\\V1\\Rest\\Ping\\Controller' => [
            'listener' => \ping\V1\Rest\Ping\PingResource::class,
            'route_name' => 'ping.rest.ping',
            'route_identifier_name' => 'ping_id',
            'collection_name' => 'ping',
            'entity_http_methods' => [],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ping\V1\Rest\Ping\PingEntity::class,
            'collection_class' => \ping\V1\Rest\Ping\PingCollection::class,
            'service_name' => 'ping',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'ping\\V1\\Rest\\Ping\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ping\\V1\\Rest\\Ping\\Controller' => [
                0 => 'application/vnd.ping.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ping\\V1\\Rest\\Ping\\Controller' => [
                0 => 'application/vnd.ping.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \ping\V1\Rest\Ping\PingEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ping.rest.ping',
                'route_identifier_name' => 'ping_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \ping\V1\Rest\Ping\PingCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'ping.rest.ping',
                'route_identifier_name' => 'ping_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'ping\\V1\\Rest\\Ping\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
