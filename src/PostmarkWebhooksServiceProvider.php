<?php

namespace Mvdnbrk\PostmarkWebhooks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mvdnbrk\PostmarkWebhooks\Http\Controllers\PostmarkWebhooksController;
use Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhitelist;

class PostmarkWebhooksServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerPublishing();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/postmark-webhooks.php', 'postmark-webhooks');
    }

    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

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

    private function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            Route::post(config('postmark-webhooks.path'), PostmarkWebhooksController::class);
        });
    }

    private function routeConfiguration(): array
    {
        return [
            'middleware' => [
                'api',
                PostmarkIpsWhitelist::class,
            ],
        ];
    }

    protected function shouldMigrate(): bool
    {
        return config('postmark-webhooks.log.enabled');
    }
}
