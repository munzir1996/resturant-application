<?php

namespace Tests\Feature\API\Client;

use App\Models\Bank;
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

    /** @test */
    public function client_can_edit_a_resturant()
    {

        $this->clientApiLogin();

        $city = City::factory()->create();
        $category = Category::factory()->create();
        $resturant = Resturant::factory()->create();
        ResturantLocation::factory()->create([
            'resturant_id' => $resturant->id,
        ]);
        Bank::factory()->create([
            'resturant_id' => $resturant->id,
        ]);

        $response = $this->put('api/client/resturants/'. $resturant->id, [
            'name_ar' => 'مطعم',
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
        $response->assertOk();

        $this->assertDatabaseHas('resturants', [
            'name_ar' => 'مطعم',
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

    /** @test */
    public function client_can_delete_a_resturant()
    {
        $this->clientApiLogin();

        $resturant = Resturant::factory()->create();

        $response = $this->delete('api/client/resturants/'. $resturant->id);
        $response->assertOk();

        $this->assertSoftDeleted('resturants', [
            'id' => $resturant->id,
        ]);
    }

}






