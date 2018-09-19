<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhooksServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PostmarkWebhooksServiceProvider::class,
        ];
    }
}
