<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'api' => env('GOOGLE_OCR_API', '')
    ],
    'cdp' =>[
        'client_id'=>'md-so-digital-stage',
        'client_secret'=>'R5k{8JX_$Zh',
        'basic_auth'=>'reckittbenckiser:t8uLkZMWNa87mxzKokKCXVQ9PEkwzXJv9YrHRD7r63WJwh5djf',
        'baseurl'=>'https://digital-security-authservice-production.frankfurt.rbdigitalcloud.com',
        'apiurl'=>'https://api.cdp-rb.com',
        'legal_version'=>'6124ec06207a4c000194298c',
        'legal_id'=>'LT-PP-MX-es-enfagrow-lp',
        'legal_description'=>'',
        'AccountSourceCode'=>'RBMEXCALWEB',
        'TierCode'=>'RBMEXCALTIER1',
        'legal_description'=>''
    ],
    'advantage' =>[
        "client_id"=>"3",
        "client_secret"=>"MXkvNDPDGBxZLi600akeODADti91q5J7AdyEfEcO",
        "url_token"=>"https://enfagrow.servicios-advantage.mx/oauth/token",
        "url_auth"=>"https://enfagrow.servicios-advantage.mx/authApi/authLogin",
        "url_base"=>"https://enfagrow.servicios-advantage.mx/%s",
    ],


];
