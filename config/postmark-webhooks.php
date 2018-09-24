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
    | If you wish to use a different table name you spcecify that here as
    | well.
    |
    | If you would like to use your own model you should extend the
    | Mvdnbrk\PostmarkWebhooks\PostmarkWebhook model.
    |
    | You may specify one or more event types to be excluded from being
    | logged to the databse. You can place them under the except key.
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

];
