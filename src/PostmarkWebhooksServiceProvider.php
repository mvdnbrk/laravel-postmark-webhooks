<?php

namespace Mvdnbrk\PostmarkWebhooks;

use Illuminate\Support\ServiceProvider;

class PostmarkWebhooksServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
