<?php

namespace Tests\Feature\API\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_a_client()
    {
        $response = $this->post('api/client/register', [
            'name' => 'jane doe',
            'email' => 'user@user.com',
            'phone' => '0114949905',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => 'jane doe',
            'email' => 'user@user.com',
            'phone' => '0114949905',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'phone' => '0123456789',
        ]);

        $this->userApiLogin($user);

        $response = $this->put('api/profile', [
            'id' => $user->id,
            'name' => 'jane doe',
            'email' => 'test@test.com',
            'phone' => '0123456789',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => 'jane doe',
            'email' => 'test@test.com',
            'phone' => '0123456789',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $this->userApiLogin($user);

        $response = $this->post('api/login', [
            'identity' => 'user@user.com',
            'password' => 'password',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function user_can_logout_and_delete_his_token()
    {
        $this->withoutExceptionHandling();

        $user = $this->userApiLogin();

        $user->createToken('user-application');

        $response = $this->post('/api/logout');

        $response->assertStatus(200);
        $this->assertCount(0, $user->tokens);
    }
}
