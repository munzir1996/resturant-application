<?php

namespace Tests\Feature\API\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_get_all_roles()
    {
        $response = $this->get('/api/client/roles');
        $response->assertOk();
        $response->assertExactJson(config('constants.roles'));
    }
}
