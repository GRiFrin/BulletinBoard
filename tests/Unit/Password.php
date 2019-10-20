<?php

namespace Tests\Unit;

use App\Rules\PasswordRules;
use Tests\TestCase;

class Password extends TestCase
{
    public function testPassword()
    {
        $rule = ['password' => [new PasswordRules()]];

        $this->assertFalse(validator(['password' => '867'], $rule)->passes());
        $this->assertFalse(validator(['password' => '12335?'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'fgh464!'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'FDDEEW464!'], $rule)->passes());
        $this->assertTrue(validator(['password' => 'sdfWER45!'], $rule)->passes());
    }
}
