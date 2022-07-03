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
        'api_key' => env("GOOGLE_CLOUD_KEY")
    ],

    'stripe' => [
        'api_key' => env('STRIPE_API_KEY'),
        'api_secret' => env('STRIPE_API_SECRET'),
    ],

    'authy' => [
        'secret' => env('AUTHY_SECRET'),
    ],

    'twilio' => [
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'from' => env('TWILIO_FROM'),
        'debug' => env('TWILIO_DEBUG_TO'),
    ]

];
