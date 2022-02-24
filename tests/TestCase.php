<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Exception;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loadFixture($path = null, $include = false): mixed
    {
        $fixture_path = __DIR__ . '/_fixtures/' . $path;

        if (!is_readable($fixture_path)) {
            throw new Exception(sprintf('Failed to read fixture path: %s', $fixture_path));
        }

       return $include ? require $fixture_path : $fixture_path;
    }
}
