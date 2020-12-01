<?php
return [
    'service_manager' => [
        'factories' => [
            \operator\V1\Rest\Ticket\TicketResource::class => \operator\V1\Rest\Ticket\TicketResourceFactory::class,
            \operator\V1\Rest\User\UserResource::class => \operator\V1\Rest\User\UserResourceFactory::class,
            \operator\V1\Rest\Ganadores\GanadoresResource::class => \operator\V1\Rest\Ganadores\GanadoresResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'operator.rest.ticket' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ticket[/:ticket_id]',
                    'defaults' => [
                        'controller' => 'operator\\V1\\Rest\\Ticket\\Controller',
                    ],
                ],
            ],
            'operator.rest.user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/user[/:user_id]',
                    'defaults' => [
                        'controller' => 'operator\\V1\\Rest\\User\\Controller',
                    ],
                ],
            ],
            'operator.rest.ganadores' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ganadores[/:ganadores_id]',
                    'defaults' => [
                        'controller' => 'operator\\V1\\Rest\\Ganadores\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'operator.rest.ticket',
            1 => 'operator.rest.user',
            2 => 'operator.rest.ganadores',
        ],
    ],
    'api-tools-rest' => [
        'operator\\V1\\Rest\\Ticket\\Controller' => [
            'listener' => \operator\V1\Rest\Ticket\TicketResource::class,
            'route_name' => 'operator.rest.ticket',
            'route_identifier_name' => 'ticket_id',
            'collection_name' => 'ticket',
            'entity_http_methods' => [
                0 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \operator\V1\Rest\Ticket\TicketEntity::class,
            'collection_class' => \operator\V1\Rest\Ticket\TicketCollection::class,
            'service_name' => 'ticket',
        ],
        'operator\\V1\\Rest\\User\\Controller' => [
            'listener' => \operator\V1\Rest\User\UserResource::class,
            'route_name' => 'operator.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'user',
            'entity_http_methods' => [],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \operator\V1\Rest\User\UserEntity::class,
            'collection_class' => \operator\V1\Rest\User\UserCollection::class,
            'service_name' => 'user',
        ],
        'operator\\V1\\Rest\\Ganadores\\Controller' => [
            'listener' => \operator\V1\Rest\Ganadores\GanadoresResource::class,
            'route_name' => 'operator.rest.ganadores',
            'route_identifier_name' => 'ganadores_id',
            'collection_name' => 'ganadores',
            'entity_http_methods' => [],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [
                0 => 'week',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \operator\V1\Rest\Ganadores\GanadoresEntity::class,
            'collection_class' => \operator\V1\Rest\Ganadores\GanadoresCollection::class,
            'service_name' => 'ganadores',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'operator\\V1\\Rest\\Ticket\\Controller' => 'HalJson',
            'operator\\V1\\Rest\\User\\Controller' => 'HalJson',
            'operator\\V1\\Rest\\Ganadores\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'operator\\V1\\Rest\\Ticket\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'operator\\V1\\Rest\\User\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'operator\\V1\\Rest\\Ganadores\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'operator\\V1\\Rest\\Ticket\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/json',
            ],
            'operator\\V1\\Rest\\User\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/json',
            ],
            'operator\\V1\\Rest\\Ganadores\\Controller' => [
                0 => 'application/vnd.operator.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \operator\V1\Rest\Ticket\TicketEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.ticket',
                'route_identifier_name' => 'ticket_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \operator\V1\Rest\Ticket\TicketCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.ticket',
                'route_identifier_name' => 'ticket_id',
                'is_collection' => true,
            ],
            \operator\V1\Rest\User\UserEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \operator\V1\Rest\User\UserCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ],
            \operator\V1\Rest\Ganadores\GanadoresEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.ganadores',
                'route_identifier_name' => 'ganadores_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \operator\V1\Rest\Ganadores\GanadoresCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'operator.rest.ganadores',
                'route_identifier_name' => 'ganadores_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'operator\\V1\\Rest\\Ticket\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'operator\\V1\\Rest\\User\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
