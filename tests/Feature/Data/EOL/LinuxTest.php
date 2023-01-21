<?php

namespace Tests\Feature\Data\EOL;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LinuxTest extends TestCase
{
    public function test_returns_cached_json(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\EOL\Linux::CACHE_KEY)
            ->andReturn(['incomplete_results' => false]);

        $response = $this->get('/data/eol/linux.json');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_returns_json_error_when_cache_is_null(): void
    {
        Cache::shouldReceive('get')
            ->once()
            ->with(\App\Console\Commands\Cache\EOL\Linux::CACHE_KEY)
            ->andReturn(null);

        $response = $this->get('/data/eol/linux.json');
        $response->assertStatus(200);
        $response->assertJSON([]);
    }
}
