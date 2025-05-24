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

    'payment_gateway' => [
        'cbk_payment' => [
            'payment_mode' => env('CBK_PAYMENT_MODE','live_mode'),
            'test_mode' => [
                'ENCRP_KEY' => 'v9anZOQ_Vt_Y6E-G1rDdO-o1pLAExDt1BN1t_8pZgrGizsJRz915HMS__exWFqX77emLtccIc9D_AGEzD2ANGT49Tdo5GGJqaovNGR2HMVk1',
                'CLIENT_ID' => '81524577',
                'CLIENT_SECRET' => 'FLNu8hD07WVXcZ3nuXI0tO74b4bMYuz-lGcmklJGo7c1',
                'PAYMENT_URL' => 'https://pgtest.cbk.com',
            ],
            'live_mode' => [
                'ENCRP_KEY' => env('CBK_ENCRP_KEY'),
                'CLIENT_ID' => env('CBK_CLIENT_ID'),
                'CLIENT_SECRET' => env('CBK_CLIENT_SECRET'),
                'PAYMENT_URL' => 'https://pg.cbk.com',
            ],
        ],
    ],
];
