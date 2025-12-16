<?php

namespace Tests\Feature\Data;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use DatabaseMigrations;

    public function test_returns_cached_json(): void
    {
        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertHeader('access-control-allow-origin', config('cors.allowed_origins.0'));
    }

    public function test_returns_json_error_when_cache_is_null(): void
    {
        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertJSON([
            'activity' => null,
            'insights' => null,
        ]);
    }
}
