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

    'firebase' => [
        'messaging' => [
            'default' => [
                'server_key' => env('FIREBASE_API_KEY'),
                'sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
            ],
        ],
        'connections' => [
            'main' => [ 
                'project_id' => env('FIREBASE_PROJECT_ID'),
                'key_file' => env('FIREBASE_CREDENTIALS'),
            ],
            // add additional connections as needed
        ],
        'api_key' => env('FIREBASE_API_KEY'),
       
        'app_id' => env('FIREBASE_APP_ID'),
        'database_url' => env('FIREBASE_DATABASE_URL'),
        'secret' => env('FIREBASE_API_KEY'), // This should be your Firebase API key
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'project_id' => env('FIREBASE_PROJECT_ID'),
        'client_id' => env('FIREBASE_CLIENT_ID'),
        'service_account' => [
            'type' => env('FIREBASE_SERVICE_ACCOUNT_TYPE'),
            'project_id' => env('FIREBASE_SERVICE_ACCOUNT_PROJECT_ID'),
            'private_key_id' => env('FIREBASE_SERVICE_ACCOUNT_PRIVATE_KEY_ID'),
            'private_key' => env('FIREBASE_SERVICE_ACCOUNT_PRIVATE_KEY'),
            'client_email' => env('FIREBASE_SERVICE_ACCOUNT_CLIENT_EMAIL'),
            'client_id' => env('FIREBASE_SERVICE_ACCOUNT_CLIENT_ID'),
            'auth_uri' => env('FIREBASE_SERVICE_ACCOUNT_AUTH_URI'),
            'token_uri' => env('FIREBASE_SERVICE_ACCOUNT_TOKEN_URI'),
            'auth_provider_x509_cert_url' => env('FIREBASE_SERVICE_ACCOUNT_AUTH_PROVIDER_X509_CERT_URL'),
            'client_x509_cert_url' => env('FIREBASE_SERVICE_ACCOUNT_CLIENT_X509_CERT_URL'),
        ],
],


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
    
    // 'fcm' => [
    //     'key' => env('FCM_KEY', 'AAAA0Yo6wYs:APA91bHIJ7iSWdaWRyeimwZAcy6v2A1bWaKZ9vPcLrIvkl4edsDSe4S_MNu4pheuQRh-XHYjrkUO3cr2QtGUhUI-hNdvW2EKBjOiG3idasnCOxpKK47GrQnwbXzLbrjiwrVmavK7uq0O'),
    //     'sender_id' => env('FCM_SENDER_ID'),
    // ],

    // 'firebase' => [
    //     // 'default' => 'main',
    //     'driver' => 'firebase',
    //     'credentials' => base_path('config/firebase_credentials.json'),
    //     'database_uri' => 'https://Dexterapp.firebaseio.com',

    //     'connections' => [
    //         'main' => [ 
    //             'project_id' => env('FIREBASE_PROJECT_ID'),
    //             'key_file' => env('FIREBASE_CREDENTIALS'),
    //         ],
    //         // add additional connections as needed
    //     ],
    // ],
];
