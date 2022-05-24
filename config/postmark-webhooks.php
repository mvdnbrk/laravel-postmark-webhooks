<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Postmark can post webhooks to.
    | Change this path to anything you like.
    |
    */

    'path' => '/api/webhooks/postmark',

    /*
    |--------------------------------------------------------------------------
    | Log Options
    |--------------------------------------------------------------------------
    |
    | Logging events to the database is enabled by default. You may set this
    | to false if you don't want to log the Postmark events to the database.
    |
    | You may specify one or more event types to be excluded from being
    | logged to the database. You can place them under the except key.
    |
    | Supported event types: "open", "bounce", "click",
    | "delivery", "spam_complaint"
    |
    */

    'log' => [
        'enabled' => env('POSTMARK_WEBHOOKS_LOG_ENABLED', true),
        'model' => \Mvdnbrk\PostmarkWebhooks\PostmarkWebhook::class,
        'table_name' => 'postmark_webhook_logs',

        'except' => [
            //
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Mapping
    |--------------------------------------------------------------------------
    |
    | This option allows you to map Postmark webhook
    | events to your own object-based events.
    |
    */

    'events' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowlist IPs
    |--------------------------------------------------------------------------
    |
    | This option allows you to set custom IPs for testing webhooks
    | with tools like ngrok
    |
    */

    'allowlist-ips' => [
        '127.0.0.1',
        '3.134.147.250',
        '18.217.206.57',
        '50.31.156.6',
        '50.31.156.77',
    ],

];
