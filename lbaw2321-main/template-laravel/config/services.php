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
        'scheme' => 'https',
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
        'client_id' => '749649110623-r88r6i61d684e6nq6og00f88s3m0b1ur.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],    

    'googlelogin' => [
        'client_id' => '749649110623-o3vj5rkdh4q1159rlfeu1eac5futu6mb.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback/login',
    ],  
];
