<?php

namespace Tests\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class MigrationTest extends TestCase
{
    /** @test */
    public function it_runs_the_migrations()
    {
        $columns = Schema::getColumnListing('postmark_webhook_logs');

        $this->assertEquals([
            'id',
            'message_id',
            'record_type',
            'payload',
            'created_at',
        ], $columns);
    }
}
