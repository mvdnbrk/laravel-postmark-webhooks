<?php

use Illuminate\Support\Facades\Route;

Route::post(config('postmark-webhooks.path'), 'PostmarkWebhooksController@store');
