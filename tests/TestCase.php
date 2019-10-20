<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function arrayContainsKeyValue(string $key, $value, array $array): bool
    {
        if (!is_array($array)) {
            return false;
        }

        if (!isset($array[$key])) {
            return false;
        }

        return ($array[$key] === $value);
    }
}
