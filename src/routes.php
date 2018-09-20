<?php

Route::post('/api/webhooks/postmark')
    ->uses('\Mvdnbrk\PostmarkWebhooks\Http\Controllers\PostmarkWebhooksController@store')
    ->middleware([
        'api',
        '\Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhiteList'
    ]);
