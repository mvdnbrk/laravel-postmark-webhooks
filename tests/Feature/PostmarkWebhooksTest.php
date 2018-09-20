<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Routing\Router;

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
        $response = $this->postJson('/api/webhooks/postmark');

        $response->assertStatus(202);
    }

    /** @test */
    public function posting_a_valid_request_from_a_non_whitelisted_ip_results_in_a_401()
    {
        $response = $this->withHeaders(['REMOTE_ADDR' => '9.9.9.9'])->postJson('/api/webhooks/postmark');

        $response->assertStatus(401);
    }
}
