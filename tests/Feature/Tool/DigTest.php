<?php

namespace Tests\Feature\Tool;

use Tests\TestCase;

class DigTest extends TestCase
{
    protected $dns_requests = [];

    public function setUp(): void
    {
        $this->dns_requests = $this->loadFixture('dig_dns_requests.php', true);

        parent::setUp();
    }

    public function test_returns_json(): void
    {
        $response = $this->post('/tool/dig', [
            'name'       => 'google.co.uk',
            'nameserver' => 'cloudflare',
            'types'      => ['a', 'aaaa'],
        ]);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_answers_valid_requests(): void
    {
        foreach ($this->dns_requests as $fixture) {
            $response = $this->post('/tool/dig', [
                'name'       => $fixture['name'],
                'nameserver' => $fixture['nameserver'],
                'types'      => $fixture['types'],
            ]);

            $response->assertStatus(200);
            $response->assertHeader('content-type', 'application/json');
            $response->assertJson([
                'success' => true,
            ]);
        }
    }

    public function test_fails_bad_input(): void
    {
        $response = $this->withHeaders(['accept' => 'application/json'])
            ->post('/tool/dig', [
                'name'       => null,
                'nameserver' => 'other',
                'types'      => ['MAILA'],
            ]);

        $response->assertStatus(422);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_redirects_bad_requests(): void
    {
        $response = $this->post('/tool/dig', [
            'name'       => 'fdjfdhjsjkfdhsjkf',
            'nameserver' => 'other',
            'types'      => ['NULL'],
        ]);

        $response->assertStatus(302);
    }
}
