<?php
// Lokasi: config/services.php
// TAMBAHKAN blok 'servizz' ke dalam array yang sudah ada di file ini.
// Jika file belum ada, buat baru dengan isi ini:

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel'              => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ── SERVIZZ API ──────────────────────────────────────────────
    'servizz' => [
        'api_url' => env('SERVIZZ_API_URL', 'http://127.0.0.1:3000'),
    ],

];