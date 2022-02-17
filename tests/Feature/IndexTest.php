<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_index_redirects_to_external_url(): void
    {
        $response = $this->get('/');
        $response->assertStatus(301);
        $response->assertRedirectContains('https://dangibbs.uk/');
    }
}
