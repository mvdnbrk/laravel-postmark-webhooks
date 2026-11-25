<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostmarkWebhookEventMappingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->withHeaders(['REMOTE_ADDR' => '50.31.156.6']);
    }

    protected function validPayload(array $attributes = []): array
    {
        return array_merge([
            'Recipient' => 'john@example.com',
            'RecordType' => 'Delivery',
            'MessageID' => '9999-9999-9999-9999-9999',
        ], $attributes);
    }

    #[Test]
    public function when_an_event_is_configured_to_be_mapped_to_a_dedicated_class_we_will_fire_that_event(): void
    {
        config(['postmark-webhooks.events' => ['some_type' => MappedFakeEvent::class]]);

        $response = $this->postJson('/api/webhooks/postmark', $this->validPayload([
            'RecordType' => 'SomeType',
        ]));

        Event::assertDispatched(MappedFakeEvent::class, function ($event) {
            if (! $event->webhook instanceof PostmarkWebhookCalled) {
                return false;
            }

            return true;
        });
    }
}

class MappedFakeEvent
{
    public $webhook;

    public function __construct(PostmarkWebhookCalled $webhook)
    {
        $this->webhook = $webhook;
    }
}
