<?php

namespace Tests;

use App\Models\Client;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function clientApiLogin($client = null)
    {
        $client = $client ? $client : Client::factory()->create();

        Sanctum::actingAs(
            $client,
            ['role:client']
        );

        return $client;
    }

}

