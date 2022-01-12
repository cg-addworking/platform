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
        'enabled' => env('FILE_STORAGE_ENABLED', false),
        'disk' => env('FILE_STORAGE_DISK', 'dev'),
        'sync-aws-scaleway' => env('FILE_STORAGE_SYNC_AWS_SCALEWAY', false),
    ],

];
