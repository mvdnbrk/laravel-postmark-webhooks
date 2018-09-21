<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhookLog;

class PostmarkWebhooksTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->withHeaders(['REMOTE_ADDR' => '50.31.156.6']);
    }

    /** @test */
    public function it_can_handle_a_valid_request()
    {
        $payload = [
            'RecordType' => 'SpamComplaint',
            'MessageID' => '9999-9999-9999-9999-9999',
        ];

        $response = $this->postJson('/api/webhooks/postmark', $payload);

        $response->assertStatus(202);
        $this->assertCount(1, PostmarkWebhookLog::all());
        tap(PostmarkWebhookLog::first(), function ($log) use ($payload) {
            $this->assertEquals('9999-9999-9999-9999-9999', $log->message_id);
            $this->assertEquals('spam_complaint', $log->record_type);
            $this->assertEquals($payload, $log->payload);
        });
    }

    /** @test */
    public function posting_a_valid_request_from_a_non_whitelisted_ip_results_in_a_401()
    {
        $payload = [
            'RecordType' => 'SpamComplaint',
            'MessageID' => '9999-9999-9999-9999-9999',
        ];

        $response = $this->withHeaders(['REMOTE_ADDR' => '9.9.9.9'])->postJson('/api/webhooks/postmark', $payload);

        $response->assertStatus(401);
        $this->assertCount(0, PostmarkWebhookLog::all());
    }
}
