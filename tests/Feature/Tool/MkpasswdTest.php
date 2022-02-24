<?php

namespace Tests\Feature\Tool;

use Tests\TestCase;

class MkpasswdTest extends TestCase
{
    protected $fail_fixtures = [];
    protected $pass_fixtures = [];

    public function setUp(): void
    {
        // Load fixtures
        $this->fail_fixtures = $this->loadFixture('mkpasswd_validation_fail.php', true);
        $this->pass_fixtures = $this->loadFixture('mkpasswd_validation_pass.php', true);

        parent::setUp();
    }

    public function test_returns_json(): void
    {
        $response = $this->post('/tool/mkpasswd', [
            'input'  => 'test123',
            'method' => 'md5crypt',
            'rounds' => 10000,
            'salt'   => 'abcdefgh',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'command' => '/usr/bin/mkpasswd test123 --method=md5crypt --rounds=10000 --salt=abcdefgh',
        ]);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_invalid_requests_fail(): void
    {
        foreach ($this->fail_fixtures as $test) {
            $response = $this->withHeaders(['accept' => 'application/json'])
                ->post('/tool/mkpasswd', [
                    'input'  => $test[0],
                    'method' => $test[1],
                    'rounds' => $test[2],
                    'salt'   => $test[3],
                ]);

            $response->assertStatus(422);
            $response->assertHeader('content-type', 'application/json');
        }
    }

    public function test_valid_requests_pass(): void
    {
        foreach ($this->pass_fixtures as $test) {
            $params = [
                'input'  => $test[0],
                'method' => $test[1],
                'rounds' => $test[2],
                'salt'   => $test[3],
            ];


            $response = $this->withHeaders(['accept' => 'application/json'])
                ->post('/tool/mkpasswd', $params);

            $response->assertStatus(200);
            $response->assertHeader('content-type', 'application/json');

            // Check the output
            $this->assertTrue(strlen($response->json('output')) > 0);


            // Check the resulting command
            $this->assertTrue(str_contains($response->json('command'), '/usr/bin/mkpasswd'));
        }
    }
}
