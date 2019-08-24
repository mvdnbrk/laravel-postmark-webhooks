<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

class PostmarkWebhookEventMappingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    protected function validPayload($attributes = [])
    {
        return array_merge([
            'Recipient' => 'john@example.com',
            'RecordType' => 'Delivery',
            'MessageID' => '9999-9999-9999-9999-9999',
        ], $attributes);
    }

    /** @test */
    public function when_an_event_is_configured_to_be_mapped_to_a_dedicated_class_we_will_fire_that_event()
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
