<?php

Route::post(config('postmark-webhooks.path'), 'PostmarkWebhooksController@store');
