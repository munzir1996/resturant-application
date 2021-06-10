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
                    'client',
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
                'client',
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

        $response = $this->post('api/client/resturants', [
            'name_ar' => 'مطعم',
            'name_en' => 'resturant',
            'manager_name' => 'مدير',
            'manager_phone' => '01542365874',
            'email' => 'client@client.com',
            'commercial_registration_no' => '011',
            'open_time' => '8am',
            'close_time' => '10pm',
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
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
        ]);
        $this->assertDatabaseHas('resturant_locations', [
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
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
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
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
        ]);
        $this->assertDatabaseHas('resturant_locations', [
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
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
        $client = $this->clientApiLogin();
        $resturant = Resturant::factory()->create([
            'client_id' => $client->id,
        ]);
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $categories = [$category1->id, $category2->id];
        $services = [1,2,3];
        $payment_methods = [1,2];

        $response = $this->post('/api/client/resturants/info/'. $resturant->id, [
            'services' => $services,
            'maximum_delivery_distance' => 100,
            'neighborhood_delivery_price' => 20,
            'outside_neighborhood_delivery_price' => 50,
            'minimum_purchase_free_delivery_in_neighborhood' => 10,
            'minimum_purchase_free_delivery_outside_neighborhood' => 20,
            'open_time' => '8am',
            'close_time' => '9pm',
            'accepted_payment_methods' => $payment_methods,
            'loyalty_points' => Resturant::YES,
            'customer_earn_points' => 0,
            'categories' => $categories,
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('resturants', [
            'maximum_delivery_distance' => 100,
            'neighborhood_delivery_price' => 20,
            'outside_neighborhood_delivery_price' => 50,
            'minimum_purchase_free_delivery_in_neighborhood' => 10,
            'minimum_purchase_free_delivery_outside_neighborhood' => 20,
            'open_time' => '8am',
            'close_time' => '9pm',
            'loyalty_points' => Resturant::YES,
            'customer_earn_points' => 0,
        ]);
        $this->assertDatabaseHas('category_resturant', [
            'resturant_id' => $resturant->id,
        ]);
        $this->assertDatabaseHas('resturant_locations', [
            'latitude' => 1554.5547,
            'longetitue' => -54.55,
            'resturant_id' => $resturant->id,
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
    public function client_can_get_all_resturants_info()
    {
        $client = $this->clientApiLogin();

        $resturant = Resturant::factory()->create([
            'client_id' => $client->id,
        ]);
        ResturantLocation::factory()->create([
            'resturant_id' => $resturant->id,
        ]);

        $response = $this->get('/api/client/resturants/info/'. $client->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'services',
                    'maximum_delivery_distance',
                    'neighborhood_delivery_price',
                    'outside_neighborhood_delivery_price',
                    'minimum_purchase_free_delivery_in_neighborhood',
                    'minimum_purchase_free_delivery_outside_neighborhood',
                    'open_time',
                    'close_time',
                    'accepted_payment_methods',
                    'loyalty_points',
                    'customer_earn_points',
                    'latitude',
                    'longetitue',
                    'categories',
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








