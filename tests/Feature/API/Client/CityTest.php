<?php

namespace Tests\Feature\API\Client;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_cities()
    {
        City::factory()->create();

        $response = $this->get('/api/client/cities');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'country_id',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_selected_city()
    {
        $city = City::factory()->create();

        $response = $this->get('/api/client/cities/'. $city->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'country_id',
            ]
        ]);
    }

}




