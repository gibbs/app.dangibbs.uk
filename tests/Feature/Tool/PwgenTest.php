<?php

namespace Tests\Feature\Tool;

use Tests\TestCase;

class PwgenTest extends TestCase
{
    protected $fail_fixtures = [];
    protected $pass_fixtures = [];

    public function setUp(): void
    {
        // Load fixtures
        $this->fail_fixtures = $this->loadFixture('pwgen_validation_fail.php', true);
        $this->pass_fixtures = $this->loadFixture('pwgen_validation_pass.php', true);

        parent::setUp();
    }

    public function test_returns_json(): void
    {
        $response = $this->post('/tool/pwgen', [
            'num-passwords' => 1,
            'length'        => 32,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'command' => '/usr/bin/pwgen -1 --num-passwords=1 32',
        ]);
        $response->assertHeader('content-type', 'application/json');
        $this->assertTrue(strlen($response->json('output')) >= 1);
    }

    public function test_invalid_requests_fail(): void
    {
        foreach ($this->fail_fixtures as $test) {
            $response = $this->withHeaders(['accept' => 'application/json'])
                ->post('/tool/pwgen', [
                    'no-numerals'   => $test[0],
                    'no-capitalize' => $test[1],
                    'ambiguous'     => $test[2],
                    'capitalize'    => $test[3],
                    'num-passwords' => $test[4],
                    'numerals'      => $test[5],
                    'remove-chars'  => $test[6],
                    'secure'        => $test[7],
                    'no-vowels'     => $test[8],
                    'symbols'       => $test[9],
                    'length'        => $test[10],
                ]);

            $response->assertStatus(422);
            $response->assertHeader('content-type', 'application/json');
        }
    }

    public function test_valid_requests_pass(): void
    {
        foreach ($this->pass_fixtures as $test) {
            $params = [
                'no-numerals'   => $test[0],
                'no-capitalize' => $test[1],
                'ambiguous'     => $test[2],
                'capitalize'    => $test[3],
                'num-passwords' => $test[4],
                'numerals'      => $test[5],
                'remove-chars'  => $test[6],
                'secure'        => $test[7],
                'no-vowels'     => $test[8],
                'symbols'       => $test[9],
                'length'        => $test[10],
            ];

            $response = $this->withHeaders(['accept' => 'application/json'])
                ->post('/tool/pwgen', $params);

            $response->assertStatus(200);
            $response->assertHeader('content-type', 'application/json');

            // Check the output
            $this->assertTrue(strlen($response->json('output')) > 0);

            // Check the resulting command
            $this->assertTrue(str_contains($response->json('command'), '/usr/bin/pwgen'));
        }
    }
}
