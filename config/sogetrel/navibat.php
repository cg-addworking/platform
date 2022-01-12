<?php

return [

    'enabled' => env('SOGETREL_NAVIBAT_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Service Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your service is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    | Values = ['local', 'staging', 'production']
    |
    */

    'env' => env('SOGETREL_NAVIBAT_ENV', 'staging'),

    'auth' => [
        'username'  => env('SOGETREL_NAVIBAT_USERNAME', null),
        'password'  => env('SOGETREL_NAVIBAT_PASSWORD', null),
    ],

    'soap_options' => [
        'connection_timeout' => 30,
        'encoding'           => 'UTF-8',
        'trace'              => true,
        'exceptions'         => true,
    ],

    'base_url_production' => "https://iris.sogetrel.fr/",
    'base_url_staging'    => "https://irispp.sogetrel.fr/",
    'base_url_local'      => "https://irisdev.sogetrel.fr/",
];
