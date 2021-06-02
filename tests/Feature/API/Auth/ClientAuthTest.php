<?php

namespace Tests\Feature\API\Auth;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_register_a_client()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/client/register', [
            'name' => 'name',
            // 'email' => 'client@client.com',
            'phone' => '0114949901',
            'country' => 'sudan',
            'job' => Client::RESTAURANT_OWNER,
            'identity_no' => '114240491',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('clients', [
            'name' => 'name',
            // 'email' => 'client@client.com',
            'phone' => '0114949901',
            'country' => 'sudan',
            'job' => Client::RESTAURANT_OWNER,
            'identity_no' => '114240491',
        ]);

    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->withoutExceptionHandling();

        $client = Client::factory()->verified()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => '0123456789',
        ]);

        $this->clientApiLogin($client);

        $response = $this->put('api/client/profile', [
            'id' => $client->id,
            'name' => 'jane doe',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'country' => 'sudan',
            'job' => Client::RESTAURANT_OWNER,
            'identity_no' => '114240491',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('clients', [
            'name' => 'jane doe',
            'email' => 'test@test.com',
            'phone' => '0123456789',
            'country' => 'sudan',
            'job' => Client::RESTAURANT_OWNER,
            'identity_no' => '114240491',
        ]);
    }

    /** @test */
    public function client_can_login()
    {
        $this->withoutExceptionHandling();

        $client = Client::factory()->create([
            'email' => 'client@client.com',
        ]);

        $this->clientApiLogin($client);

        $response = $this->post('api/client/login', [
            'identity' => 'client@client.com',
            'password' => 'password',
        ]);
        $response->assertOk();

    }

    /** @test */
    public function client_can_logout_and_delete_his_token()
    {
        $this->withoutExceptionHandling();

        $client = $this->clientApiLogin();

        $client->createToken('mobile-client');

        $response = $this->post('/api/client/logout');

        $response->assertOk();
        $this->assertCount(0, $client->tokens);
    }

}
