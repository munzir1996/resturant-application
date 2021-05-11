<?php

namespace Tests\Feature\API\Client;

use App\Models\Resturant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResturantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_get_all_resturants()
    {

        $this->clientApiLogin();
        Resturant::factory(2)->create();

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
                ]
            ]
        ]);
    }

    /** @test */
    public function client_can_get_selected_resturant()
    {

        $this->clientApiLogin();
        $resturant = Resturant::factory()->create();

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
            ]
        ]);
    }

}


