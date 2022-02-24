<?php

namespace Tests\Feature\Tool;

use Tests\TestCase;

class UuidTest extends TestCase
{
    public function test_returns_json(): void
    {
        $response = $this->post('/tool/uuidgen', [
            'random' => true,
        ]);

        // Assertions
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'command' => '/usr/bin/uuidgen --random',
        ]);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_valid_parameters_succeed(): void
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/tool/uuidgen', [
            'random' => true,
            'time'   => true,
            'bumf'   => '123',
        ]);

        // Assertions
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'command' => '/usr/bin/uuidgen --random --time',
        ]);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_invalid_parameters_fail(): void
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/tool/uuidgen', [
            'random' => 'abc',
            'time'   => 'false',
        ]);

        // Assertions
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The random field must be true or false. (and 1 more error)',
        ]);
        $response->assertHeader('content-type', 'application/json');
    }
}
