<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhookLog;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

class PostmarkWebhooksTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Event::fake();

        $this->withHeaders(['REMOTE_ADDR' => '50.31.156.6']);
    }

    protected function validPayload($attributes = [])
    {
        return array_merge([
            'RecordType' => 'SpamComplaint',
            'MessageID' => '9999-9999-9999-9999-9999',
        ], $attributes);
    }

    /** @test */
    public function it_can_handle_a_valid_request()
    {
        $payload = [
            'RecordType' => 'SomeType',
            'MessageID' => '123456789',
        ];

        $response = $this->postJson('/api/webhooks/postmark', $payload);

        $response->assertStatus(202);

        $this->assertCount(1, PostmarkWebhookLog::all());

        tap(PostmarkWebhookLog::first(), function ($log) use ($payload) {
            $this->assertEquals('123456789', $log->message_id);
            $this->assertEquals('some_type', $log->record_type);
            $this->assertEquals($payload, $log->payload);
        });

        Event::assertDispatched(PostmarkWebhookCalled::class, function ($event) {
            return $event->messageId === '123456789'
                && $event->recordType === 'some_type';
        });
    }

    /** @test */
    public function posting_a_valid_request_from_a_non_whitelisted_ip_results_in_a_401()
    {
        $response = $this->withHeaders(['REMOTE_ADDR' => '9.9.9.9'])->postJson('/api/webhooks/postmark', $this->validPayload([
            'RecordType' => 'open',
        ]));

        $response->assertStatus(401);

        $this->assertCount(0, PostmarkWebhookLog::all());

        Event::assertNotDispatched(PostmarkWebhookCalled::class);
    }
}
