<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class KernelTest extends TestCase
{
    use DatabaseMigrations;

    public function test_schedule_is_parsable()
    {
        $this->artisan('schedule:list')->assertExitCode(0);
    }
}
