<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhitelist;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\Attributes\Test;

class RouteMiddlewareTest extends TestCase
{
    protected function useWebMiddleware($app): void
    {
        $app['config']->set('postmark-webhooks.middleware', ['web']);
    }

    protected function webhookRouteMiddleware(): array
    {
        return Route::getRoutes()->match(
            request()->create('/api/webhooks/postmark', 'POST')
        )->middleware();
    }

    #[Test]
    public function the_route_uses_the_api_middleware_group_by_default(): void
    {
        $this->assertSame(['api', PostmarkIpsWhitelist::class], $this->webhookRouteMiddleware());
    }

    #[Test]
    #[DefineEnvironment('useWebMiddleware')]
    public function the_middleware_can_be_configured_and_keeps_the_ip_check(): void
    {
        $this->assertSame(['web', PostmarkIpsWhitelist::class], $this->webhookRouteMiddleware());
    }
}
