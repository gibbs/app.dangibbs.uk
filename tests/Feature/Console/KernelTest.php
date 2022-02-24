<?php

namespace Tests\Feature\Console;

use Tests\TestCase;

class KernelTest extends TestCase
{
    public function test_schedule_is_parsable()
    {
        $this->artisan('schedule:list')->assertExitCode(0);
    }
}
