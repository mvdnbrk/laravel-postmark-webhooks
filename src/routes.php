<?php

Route::post('/api/webhooks/postmark')
    ->uses('\Mvdnbrk\PostmarkWebhooks\Http\Controllers\PostmarkWebhooksController@store');
