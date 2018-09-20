<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhooksServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PostmarkWebhooksServiceProvider::class,
        ];
    }
}
