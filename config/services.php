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
        'api_key' => env('GOOGLE_CLOUD_KEY'),
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
    ],

    'ovh' => [
        'app_key' => env('OVH_APP_KEY', 'YOUR_APP_KEY_HERE'),
        'app_secret' => env('OVH_APP_SECRET', 'YOUR_APP_SECRET_HERE'),
        'endpoint' => env('OVH_ENDPOINT', 'OVH_ENDPOINT_HERE'),
        'consumer_key' => env('OVH_CONSUMER_KEY', 'YOUR_CONSUMER_KEY_HERE'),
        'sms_account' => env('OVH_SMS_ACCOUNT', 'sms-xxxxxxx-x'),
        'sms_default_sender' => env('OVH_SMS_DEFAULT_SENDER', 'SENDER_NAME'),
        'sms_sandbox_mode' => env('OVH_SMS_SANDBOX_MODE', false),
    ],

    'selectra' => [
        'token' => env('API_SELECTRA_TOKEN')
    ],

    'google_api' => [
        'api_key' => env("GOOGLE_API_KEY")
    ]

];
