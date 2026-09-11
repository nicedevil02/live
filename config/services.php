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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'smsir' => [
        'api_key'     => env('SMSIR_API_KEY', 'MtHdSU31WeTLNQuzwSeN5bmk8OBRvvzhW6hiUL64o1EdJr4x'),
        'line_number' => env('SMSIR_LINE_NUMBER', null),
        'template_id' => env('SMSIR_TEMPLATE_ID', null),
        'admin_phone' => env('ADMIN_PHONE', '09187009064'),
    ],

    's_api' => [
        'token'       => env('S_API_TOKEN', 'YHXBYFzp8RGLVUgspjKKtwrm/h4WkEKr2zRHnmv2t3auZQKdvKmz4hdD6H8WwQoYYg6ONc9bEO6pMf5rnLoo4y1d5G3uFr1FmOUs+kzq0Os='),
        'endpoint'    => env('S_API_ENDPOINT', 'https://s.api.ir/api/sw1/SmsOTP'),
        'template'    => (int) env('S_API_TEMPLATE', 1),
        'admin_phone' => env('ADMIN_PHONE', '09187009064'),
    ],

    'zarinpal' => [
        'merchant_id' => env('ZARINPAL_MERCHANT_ID', 'sandbox'),
        'sandbox'     => env('ZARINPAL_SANDBOX', true),
        'zaringate'   => env('ZARINPAL_ZARINGATE', false),
    ],

    'zibal' => [
        'merchant_id' => env('ZIBAL_MERCHANT_ID', 'zibal'),
    ],
];
