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
                    'name_en',
                    'manager_name',
                    'manager_phone',
                    'email',
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
                'name_en',
                'manager_name',
                'manager_phone',
                'email',
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
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
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
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
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
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
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
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
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

    /** @test */
    public function client_can_create_resturant_basic_info()
    {
        $this->clientApiLogin();

        $response = $this->post('/api/client/resturants/basic/info', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
            'commercial_registration_no' => '1559',
            'bank_name' => 'Bank Of Khartoum',
            'iban' => '149554',
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('resturants', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
            'commercial_registration_no' => '1559',
        ]);
        $this->assertDatabaseHas('banks', [
            'name' => 'Bank Of Khartoum',
            'iban' => '149554',
        ]);
    }

    /** @test */
    public function client_can_create_resturant_info()
    {
        $this->clientApiLogin();

        $response = $this->post('/api/client/resturants/basic/info', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
            'commercial_registration_no' => '1559',
            'bank_name' => 'Bank Of Khartoum',
            'iban' => '149554',
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('resturants', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
            'commercial_registration_no' => '1559',
        ]);
        $this->assertDatabaseHas('banks', [
            'name' => 'Bank Of Khartoum',
            'iban' => '149554',
        ]);
    }

    /** @test */
    public function client_can_get_all_resturants_basic_info()
    {
        $client = $this->clientApiLogin();

        Resturant::factory(2)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->get('/api/client/resturants/basic/info/'. $client->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name_ar',
                    'name_en',
                    'manager_name',
                    'manager_phone',
                    'email',
                    'commercial_registration_no',
                    'client_id',
                ]
            ]
        ]);
    }

    /** @test */
    public function client_can_get_resturants_services()
    {
        $response = $this->get('/api/client/restaurant/services');
        $response->assertOk();
        $response->assertExactJson(config('constants.restaurant_services'));
    }

    /** @test */
    public function client_can_get_payment_methods()
    {
        $response = $this->get('/api/client/restaurant/payment/methods');
        $response->assertOk();
        $response->assertExactJson(config('constants.payment_methods'));
    }

}









