<?php

namespace Tests\Feature\API;

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
        $response = $this->get('/api/countries');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'code',
                    'key',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_get_selected_country()
    {

        $country = Country::factory()->create();
        $response = $this->get('/api/countries/'. $country->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'code',
                'key',
            ]
        ]);
    }


}


