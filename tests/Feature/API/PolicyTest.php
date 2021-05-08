<?php

namespace Tests\Feature\API;

use App\Models\Policy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_policy()
    {
        Policy::factory()->create();

        $response = $this->get('/api/policies');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'terms',
                'accept',
            ]
        ]);

    }
}
