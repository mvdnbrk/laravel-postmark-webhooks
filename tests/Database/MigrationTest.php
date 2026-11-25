<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_runs_the_migrations(): void
    {
        $columns = Schema::getColumnListing('postmark_webhook_logs');

        $this->assertEquals([
            'id',
            'message_id',
            'record_type',
            'email',
            'payload',
            'created_at',
        ], $columns);
    }
}
