<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Document storage
    |--------------------------------------------------------------------------
    |
    | This value is the name of the filesystem you want to backup vendor
    | documents to. Leave it to NULL to prevent backup. See
    | config/filesystem.php for a list of available data-stores.
    |
    */

    'storage' => [

        'enabled' => env('DOCUMENT_STORAGE_ENABLED', false),

        'disk' => env('DOCUMENT_STORAGE_DISK', 'local'),

    ],

];
