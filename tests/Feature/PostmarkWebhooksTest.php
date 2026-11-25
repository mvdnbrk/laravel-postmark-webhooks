<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhook;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostmarkWebhooksTest extends TestCase
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
    public function it_can_handle_a_valid_request(): void
    {
        $payload = [
            'Recipient' => 'jane@example.com',
            'RecordType' => 'SomeType',
            'MessageID' => '123456789',
        ];

        $response = $this->postJson('/api/webhooks/postmark', $payload);

        $response->assertStatus(202);

        $this->assertCount(1, PostmarkWebhook::all());

        tap(PostmarkWebhook::first(), function ($log) use ($payload) {
            $this->assertEquals('jane@example.com', $log->email);
            $this->assertEquals('123456789', $log->message_id);
            $this->assertEquals('some_type', $log->record_type);
            $this->assertEquals($payload, $log->payload);
        });

        Event::assertDispatched(PostmarkWebhookCalled::class, function ($event) {
            return $event->messageId === '123456789'
                && $event->recordType === 'some_type'
                && $event->email === 'jane@example.com';
        });

        Event::assertDispatched('webhook.postmark: some_type', function ($event, $eventPayload) {
            if (! $eventPayload instanceof PostmarkWebhookCalled) {
                return false;
            }

            return $eventPayload->messageId === '123456789'
                && $eventPayload->recordType === 'some_type'
                && $eventPayload->email === 'jane@example.com';
        });
    }

    #[Test]
    public function it_does_not_log_to_the_database_if_this_is_configured_to_be_disabled(): void
    {
        config(['postmark-webhooks.log.enabled' => false]);

        $response = $this->postJson('/api/webhooks/postmark', $this->validPayload());

        $response->assertStatus(202);
        $this->assertCount(0, PostmarkWebhook::all());
    }

    #[Test]
    public function it_does_not_log_to_the_database_if_the_record_type_is_configured_to_be_excepted(): void
    {
        config(['postmark-webhooks.log.except' => ['open']]);

        $response = $this->postJson('/api/webhooks/postmark', $this->validPayload([
            'RecordType' => 'Open',
        ]));

        $response->assertStatus(202);
        $this->assertCount(0, PostmarkWebhook::all());
    }

    #[Test]
    public function event_type_of_bounce_uses_the_email_field_instead_of_recipient(): void
    {
        $response = $this->postJson('/api/webhooks/postmark', [
            'MessageID' => '1234',
            'RecordType' => 'Bounce',
            'Email' => 'jane@example.com',
        ]);

        $response->assertStatus(202);

        tap(PostmarkWebhook::first(), function ($log) {
            $this->assertEquals('jane@example.com', $log->email);
        });

        Event::assertDispatched(PostmarkWebhookCalled::class, function ($event) {
            return $event->email === 'jane@example.com';
        });
    }

    #[Test]
    public function event_type_of_spam_complaint_uses_the_email_field_instead_of_recipient(): void
    {
        $response = $this->postJson('/api/webhooks/postmark', [
            'MessageID' => '1234',
            'RecordType' => 'SpamComplaint',
            'Email' => 'jane@example.com',
        ]);

        $response->assertStatus(202);

        tap(PostmarkWebhook::first(), function ($log) {
            $this->assertEquals('jane@example.com', $log->email);
        });

        Event::assertDispatched(PostmarkWebhookCalled::class, function ($event) {
            return $event->email === 'jane@example.com';
        });
    }

    #[Test]
    public function posting_a_valid_request_from_a_non_whitelisted_ip_results_in_a_401(): void
    {
        $response = $this->withHeaders(['REMOTE_ADDR' => '9.9.9.9'])->postJson('/api/webhooks/postmark', $this->validPayload());

        $response->assertStatus(401);

        $this->assertCount(0, PostmarkWebhook::all());

        Event::assertNotDispatched(PostmarkWebhookCalled::class);
        Event::assertNotDispatched('webhook.postmark:*');
    }

    #[Test]
    public function posting_a_request_from_localhost_results_in_a_401(): void
    {
        $response = $this->withHeaders(['REMOTE_ADDR' => '127.0.0.1'])->postJson('/api/webhooks/postmark', $this->validPayload());

        $response->assertStatus(401);

        $this->assertCount(0, PostmarkWebhook::all());
    }

    #[Test]
    public function the_ip_check_is_skipped_in_the_local_environment(): void
    {
        $this->app['env'] = 'local';

        $response = $this->withHeaders(['REMOTE_ADDR' => '9.9.9.9'])->postJson('/api/webhooks/postmark', $this->validPayload());

        $response->assertStatus(202);

        $this->assertCount(1, PostmarkWebhook::all());
    }
}
