<?php

namespace Tests\Feature\Data;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    public function test_returns_cached_json(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\ActivityFeed::CACHE_KEY)
            ->andReturn(['incomplete_results' => false]);

        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\Insights::CACHE_KEY)
            ->andReturn(['incomplete_results' => false]);

        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_returns_json_error_when_cache_is_null(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\ActivityFeed::CACHE_KEY)
            ->andReturn(null);

        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\Insights::CACHE_KEY)
            ->andReturn(null);

        $response = $this->get('/data/activity-feed.json');
        $response->assertStatus(200);
        $response->assertJSON([
            'activity' => null,
            'insights' => null,
        ]);
    }
}
