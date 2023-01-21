<?php

namespace Tests\Feature\Console\Cache\EOL;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LinuxTest extends TestCase
{
    use DatabaseMigrations;

    protected $key;

    public function setUp(): void
    {
        $this->key = \App\Console\Commands\Cache\EOL\Linux::CACHE_KEY;
        parent::setUp();
    }

    public function test_command_runs_and_caches_result(): void
    {
        $this->artisan('cache:eol-linux')->assertExitCode(0);

        // Cache entry created
        $this->assertTrue(Cache::has($this->key));

        // Items in cache
        $this->assertNotEmpty(Cache::get($this->key));
    }
}
