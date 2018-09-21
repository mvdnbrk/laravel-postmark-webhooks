<?php

namespace Tests\Database;

use Tests\TestCase;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhookLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostmarkWebhookLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_postmark_webhook_log()
    {
        $payload = [
            'RecordType' => 'Open',
            'FirstOpen' => true,
        ];

        PostmarkWebhookLog::create([
            'message_id' => '9999-9999-9999-9999-9999',
            'record_type' => 'open',
            'payload' => json_encode($payload),
        ]);

        tap(PostmarkWebhookLog::first(), function ($log) use ($payload) {
            $this->assertEquals('9999-9999-9999-9999-9999', $log->message_id);
            $this->assertEquals('open', $log->record_type);
            $this->assertJson($log->payload);
            $this->assertJsonStringEqualsJsonString(json_encode($payload), $log->payload);
        });
    }
}
