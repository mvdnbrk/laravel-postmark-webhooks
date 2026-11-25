<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhook;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PostmarkWebhookTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_sets_the_correct_table_name(): void
    {
        config(['postmark-webhooks.log.table_name' => 'test_table_name']);
        $this->assertEquals('test_table_name', (new PostmarkWebhook())->getTable());

        $this->assertEquals('dummy_table', (new DummyPostmarkWebhook())->getTable());
    }

    #[Test]
    public function it_can_create_a_postmark_webhook(): void
    {
        $payload = [
            'RecordType' => 'Open',
            'FirstOpen' => true,
        ];

        PostmarkWebhook::forceCreate([
            'email' => 'john@example.com',
            'message_id' => '9999-9999-9999-9999-9999',
            'record_type' => 'open',
            'payload' => $payload,
        ]);

        $this->assertCount(1, PostmarkWebhook::all());
        tap(PostmarkWebhook::first(), function ($webhook) use ($payload) {
            $this->assertEquals('9999-9999-9999-9999-9999', $webhook->message_id);
            $this->assertEquals('open', $webhook->record_type);

            $this->assertJson($webhook->getRawOriginal('payload'));
            $this->assertJsonStringEqualsJsonString(json_encode($payload), $webhook->getRawOriginal('payload'));
        });
    }

    #[Test]
    public function it_can_create_a_postmark_webhook_from_payload(): void
    {
        $payload = [
            'Recipient' => 'john@example.com',
            'MessageID' => '9999-9999-9999-9999-9999',
            'RecordType' => 'Open',
        ];

        PostmarkWebhook::createOrNewFromPayload($payload);

        $this->assertCount(1, PostmarkWebhook::all());
        tap(PostmarkWebhook::first(), function ($webhook) use ($payload) {
            $this->assertEquals('9999-9999-9999-9999-9999', $webhook->message_id);
            $this->assertEquals('open', $webhook->record_type);
            $this->assertEquals('john@example.com', $webhook->email);

            $this->assertJson($webhook->getRawOriginal('payload'));
            $this->assertJsonStringEqualsJsonString(json_encode($payload), $webhook->getRawOriginal('payload'));
        });
    }

    #[Test]
    public function it_returns_a_new_postmark_webhook_instance_when_logging_to_database_is_disabled(): void
    {
        config(['postmark-webhooks.log.enabled' => false]);

        $payload = [
            'Recipient' => 'john@example.com',
            'MessageID' => '9999-9999-9999-9999-9999',
            'RecordType' => 'Open',
        ];

        $webhook = PostmarkWebhook::createOrNewFromPayload($payload);

        $this->assertCount(0, PostmarkWebhook::all());

        $this->assertEquals('9999-9999-9999-9999-9999', $webhook->message_id);
        $this->assertEquals('open', $webhook->record_type);
        $this->assertEquals('john@example.com', $webhook->email);
        $this->assertEquals($payload, $webhook->payload);
    }
}

class DummyPostmarkWebhook extends PostmarkWebhook
{
    protected $table = 'dummy_table';
}
