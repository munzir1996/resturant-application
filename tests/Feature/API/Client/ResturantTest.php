<?php

namespace Tests\Feature\API\Client;

use App\Models\Category;
use App\Models\City;
use App\Models\Resturant;
use App\Models\ResturantLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResturantTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function client_can_get_all_resturants()
    {

        $this->clientApiLogin();
        $resturant = Resturant::factory()->create();
        ResturantLocation::factory()->create([
            'resturant_id' => $resturant->id,
        ]);

        $response = $this->get('/api/client/resturants');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name_ar',
                    'commercial_registration_no',
                    'open_time',
                    'close_time',
                    'delivery',
                    'client',
                    'category',
                    'resturant_location',
                    'banks',
                ]
            ]
        ]);
    }

    /** @test */
    public function client_can_get_selected_resturant()
    {

        $this->clientApiLogin();
        $resturant = Resturant::factory()->create();
        ResturantLocation::factory()->create([
            'resturant_id' => $resturant->id,
        ]);

        $response = $this->get('/api/client/resturants/'. $resturant->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name_ar',
                'commercial_registration_no',
                'open_time',
                'close_time',
                'delivery',
                'client',
                'category',
                'resturant_location',
                'banks',
            ]
        ]);
    }

    /** @test */
    public function client_can_create_resturant()
    {
        $this->withoutExceptionHandling();
        $this->clientApiLogin();

        $city = City::factory()->create();
        $category = Category::factory()->create();

        $response = $this->post('api/client/resturants', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'commercial_registration_no' => '011',
            'open_time' => '8am',
            'close_time' => '10pm',
            'delivery' => Resturant::NO,
            'category_id' => $category->id,
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
            'country_id' => $city->country->id,
            'city_id' => $city->id,
            'bank_name' => 'BOK',
            'iban' => 14240,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('resturants', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'commercial_registration_no' => '011',
            'open_time' => '8am',
            'close_time' => '10pm',
            'delivery' => Resturant::NO,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('resturant_locations', [
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
            'country_id' => $city->country->id,
            'city_id' => $city->id,
        ]);

        $this->assertDatabaseHas('banks', [
            'name' => 'BOK',
            'iban' => 14240,
        ]);

    }

}






