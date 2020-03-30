<?php

return [

    'disks' => [

        'assets-public' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => env('APP_URL'),
            'visibility' => 'public',
        ],

        'badges-js' => [
            'driver' => 'local',
            'root' => public_path('badges/js'),
            'url' => env('APP_URL').'/badges/js',
            'visibility' => 'public',
        ],

        'badges-img' => [
            'driver' => 'local',
            'root' => public_path('badges/img'),
            'url' => env('APP_URL').'/badges/img',
            'visibility' => 'public',
        ],

        'badges-js-s3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'root' => 'badges/js/',
        ],

        'badges-img-s3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'root' => 'badges/img/',
        ],

    ],

];
