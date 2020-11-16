<?php

namespace Mvdnbrk\PostmarkWebhooks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhitelist;

class PostmarkWebhooksServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/postmark-webhooks.php', 'postmark-webhooks');
    }

    /**
     * Register the migrations for this package.
     *
     * @return void
     */
    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register the publishable resources for this package.
     *
     * @return void
     */
    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/postmark-webhooks.php' => config_path('postmark-webhooks.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        });
    }

    /**
     * Get the route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration(): array
    {
        return [
            'namespace' => 'Mvdnbrk\PostmarkWebhooks\Http\Controllers',
            'middleware' => [
                'api',
                PostmarkIpsWhitelist::class,
            ],
        ];
    }

    /**
     * Determine if we should register the migrations.
     *
     * @return bool
     */
    protected function shouldMigrate(): bool
    {
        return config('postmark-webhooks.log.enabled');
    }
}
