<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('temp'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'dev' => [
            'driver' => 'local',
            'root' => public_path('dev'),
            'url' => env('APP_URL').'/dev',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'files_s3' => [
            'driver' => 's3',
            'key' => env('AWS_FILES_KEY'),
            'secret' => env('AWS_FILES_SECRET'),
            'region' => env('AWS_FILES_REGION'),
            'bucket' => env('AWS_FILES_BUCKET'),
        ],

        'scaleway_s3' => [
            'driver'   => 's3',
            'key'      => env('SCALEWAY_FILES_KEY'),
            'secret'   => env('SCALEWAY_FILES_SECRET'),
            'region'   => env('SCALEWAY_FILES_REGION'),
            'bucket'   => env('SCALEWAY_FILES_BUCKET'),
            'endpoint' => env('SCALEWAY_FILES_ENDPOINT')
        ],

        'documents_s3' => [
            'driver' => 's3',
            'key' => env('AWS_DOCUMENTS_KEY'),
            'secret' => env('AWS_DOCUMENTS_SECRET'),
            'region' => env('AWS_DOCUMENTS_REGION'),
            'bucket' => env('AWS_DOCUMENTS_BUCKET'),
        ],

        'datalake' => [
            'driver' => 's3',
            'key' => env('AWS_DATA_LAKE_KEY'),
            'secret' => env('AWS_DATA_LAKE_SECRET'),
            'region' => env('AWS_DATA_LAKE_REGION'),
            'bucket' => env('AWS_DATA_LAKE_BUCKET'),
        ],

        'sogetrel' => [
            'driver'   => 'ftp',
            'host'     => env('SOGETREL_FTP_HOST'),
            'username' => env('SOGETREL_FTP_USERNAME'),
            'password' => env('SOGETREL_FTP_PASSWORD'),
        ]

    ],

];
