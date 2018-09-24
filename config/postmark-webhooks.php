<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log options
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
        'table' => 'postmark_webhook_logs',
        'model' => Mvdnbrk\PostmarkWebhooks\PostmarkWebhook::class,
        'except' => [

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Event mapping
    |--------------------------------------------------------------------------
    |
    | This option allows you to map Postmark webhook
    | events to your own object-based events.
    |
    */

    'events' => [

    ],

];
