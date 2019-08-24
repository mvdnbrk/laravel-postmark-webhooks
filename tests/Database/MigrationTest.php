<?php

namespace Mvdnbrk\PostmarkWebhooks\Tests\Database;

use Illuminate\Support\Facades\Schema;
use Mvdnbrk\PostmarkWebhooks\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_runs_the_migrations()
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
