<?php

use Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhitelist;

Route::post('/api/webhooks/postmark')
    ->uses('\Mvdnbrk\PostmarkWebhooks\Http\Controllers\PostmarkWebhooksController@store')
    ->middleware([
        'api',
        PostmarkIpsWhitelist::class,
    ]);
