<?php

namespace Tests\Feature\Console\Cache;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use DatabaseMigrations;

    protected $key;

    public function setUp(): void
    {
        $this->key = \App\Console\Commands\Cache\ActivityFeed::CACHE_KEY;
        parent::setUp();
    }

    public function test_command_runs_and_caches_result(): void
    {
        $this->artisan('cache:activityfeed')->assertExitCode(0);

        // Cache entry created
        $this->assertTrue(Cache::has($this->key));

        // Items in cache
        $item = Cache::get($this->key);
        $this->assertNotEmpty($item['items']);
    }
}
