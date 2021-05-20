<?php

namespace Tests\Feature\API\Client;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_countries()
    {

        Country::factory()->create();
        $response = $this->get('/api/client/countries');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'code',
                    'key',
                    'cities'
                ]
            ]
        ]);
    }

    /** @test */
    public function can_get_selected_country()
    {

        $country = Country::factory()->create();

        $response = $this->get('/api/client/countries/'. $country->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'code',
                'key',
                'cities'
            ]
        ]);
    }


}


