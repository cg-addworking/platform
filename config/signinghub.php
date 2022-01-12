<?php

return [

    'enabled' => env('SIGNINHUB_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | API authentication credentials
    |--------------------------------------------------------------------------
    |
    | See: https://web.signinghub.com/Web#/Enterprise/Integration
    | API Documentation: http://manuals.ascertia.com/SigningHub-apiguide
    |
    */

    'auth' => [

        'client_id' => env('SIGNINHUB_CLIENT_ID', ''),
        'secret'    => env('SIGNINHUB_SECRET', ''),
        'username'  => env('SIGNINHUB_USERNAME', ''),
        'password'  => env('SIGNINHUB_PASSWORD', ''),

    ],

    /*
    |--------------------------------------------------------------------------
    | Local signature iframe route
    |--------------------------------------------------------------------------
    |
    | This route will be used if SigningHub is disabled (see above) to
    | mimic the behavior of the SigningHub signing iframe.
    |
    */

    'local_iframe_route' => 'contract.iframe',

    /*
    |--------------------------------------------------------------------------
    | Signature areas definitions
    |--------------------------------------------------------------------------
    |
    | Hint : pages are actualy 612x792 pixels
    |
    */

    'signature_areas' => [

        'cps1' => [
            1 => [
                'order'  => 1,
                'width'  => 200,
                'height' => 200,
                'search_text' => 'Pour le Client',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            2 => [
                'order'  => 2,
                'width'  => 200,
                'height' => 200,
                'search_text' => 'Pour Addworking',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],

        'cps2' => [
            1 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Prestataire',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            2 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour Addworking',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],


        'cps3' => [
            1 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Prestataire',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            2 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Client',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],

        'cps3_eotim' => [
            2 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Prestataire',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            1 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Client',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],

        'cps3_coursierfr' => [
            1 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Prestataire',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            2 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Client',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],

        'cps3_grdf' => [
            2 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Prestataire',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
            1 => [
                'width'  => 255 - 10,
                'height' => 121 - 15,
                'search_text' => 'Pour le Client',
                'placement' => 'BOTTOM',
                'field_type' => 'ELECTRONIC_SIGNATURE',
                'placeholder' => 'Signature',
            ],
        ],

    ],

];
