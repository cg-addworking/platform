<?php

return [
    'jwt' => [
        'secret' => env('APP_KEY'),
        'algorithm' => 'HS256'
    ],

    'content' => [
        'secret' => env('APP_KEY'),
        'algorithm' => 'aes256',
        'iv' => '1982736058736512',
    ]
];
