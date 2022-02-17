<?php

namespace Tests\Feature\Console;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheActivityFeedTest extends TestCase
{
    use DatabaseMigrations;

    protected $key;

    public function setUp(): void
    {
        $this->key = 'github_activity_feed';
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
