<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testEnv(): void
    {
        $appName = env("YOUTUBE");

        self::assertEquals("Programer Zaman Now", $appName);
    }
}

