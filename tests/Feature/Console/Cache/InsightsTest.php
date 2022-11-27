<?php

namespace Tests\Feature\Console\Cache;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class InsightsTest extends TestCase
{
    use DatabaseMigrations;

    protected $key;

    public function setUp(): void
    {
        $this->key = 'github_insights_languages';
        parent::setUp();
    }

    public function test_command_runs_and_caches_result(): void
    {
        $this->artisan('cache:insights')->assertExitCode(0);

        // Cache entry created
        $this->assertTrue(Cache::has($this->key));

        // Items in cache
        $this->assertNotEmpty(Cache::get($this->key));
    }
}
