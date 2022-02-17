<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class DataTest extends TestCase
{
    public function test_returns_cached_json(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('github_activity_feed')
            ->andReturn(['incomplete_results' => false]);

        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_returns_json_error_when_cache_is_null(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with('github_activity_feed')
            ->andReturn(null);

        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertJSON([
            'success' => false,
        ]);
    }
}
