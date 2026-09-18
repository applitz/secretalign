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

    'openrouter' => [
        'key' => env('OPENROUTER_KEY'),
        'model' => env('OPENROUTER_MODEL', 'google/gemini-2.5-flash-lite'),
        'fallback_model' => env('OPENROUTER_FALLBACK_MODEL', 'google/gemini-2.5-flash'),
        // Confidence below which an image is treated as "needs manual review".
        'min_confidence' => env('OPENROUTER_MIN_CONFIDENCE', 0.6),
        // Optional labelled reference photos used as few-shot examples for the hardest
        // calls. Drop real, confirmed examples here (kept out of the repo, in storage).
        'buccal_ref_left' => env('OPENROUTER_BUCCAL_REF_LEFT', storage_path('app/references/buccal_left.jpg')),
        'buccal_ref_right' => env('OPENROUTER_BUCCAL_REF_RIGHT', storage_path('app/references/buccal_right.jpg')),
    ],

];
