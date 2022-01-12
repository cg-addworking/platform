<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Customer Service Providers
    |--------------------------------------------------------------------------
    |
    | Here you may register the service providers used to customize application
    | behavior to suit the needs of one or many customers. Each of these
    | service providers should have a "shouldBoot" that returns a boolean
    | stating whether the provider should be loaded or not.
    |
    */

    'providers' => [
        App\Providers\Customer\SogetrelServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Customer Enterprises List
    |--------------------------------------------------------------------------
    |
    | The customer enterprises.
    |
    */

    'enterprises' => [
        'COURSIERFR' => [
            'name'  => "COURSIERFR",
            'label' => "Coursier.fr",
            'subdomain' => "coursier-fr",
        ],

        'GCS EUROPE' => [
            'name'  => "GCS EUROPE",
            'label' => "GCS Europe (EOTIM)",
            'subdomain' => "gcs-europe",
        ],

        'SOGETREL' => [
            'name'  => "SOGETREL",
            'label' => "Sogetrel",
            'subdomain' => "sogetrel",
        ],

        'STARS SERVICE' => [
            'name'  => "STARS SERVICE",
            'label' => "Stars Service",
            'subdomain' => "stars-service",
        ],

        'TSE EXPRESS MEDICAL' => [
            'name'  => "TSE EXPRESS MEDICAL",
            'label' => "TSE Express Medical",
            'subdomain' => "tse-express-medical",
        ],
    ],
];
