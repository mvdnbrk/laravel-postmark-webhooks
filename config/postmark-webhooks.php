<?php

return [

    'log' => [
        'enabled' => env('POSTMARK_WEBHOOKS_LOG_ENABLED', true),
        'table' => 'postmark_webhook_logs',
    ],

];
