<?php

namespace Tests\Feature\API\Client;

use App\Models\Resturant;
use App\Models\ResturantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResturantServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_get_all_resturant_services()
    {
        $this->clientApiLogin();
        $this->withoutExceptionHandling();

        ResturantService::factory()->create();

        $response = $this->get('/api/client/resturantservices');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'resturant_id',
                ]
            ]
        ]);
    }

    /** @test */
    public function client_can_get_selected_resturant_service()
    {

        $this->clientApiLogin();
        $this->withoutExceptionHandling();

        $resturantService = ResturantService::factory()->create();

        $response = $this->get('/api/client/resturantservices/'. $resturantService->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'resturant_id',
            ]
        ]);

    }

    /** @test */
    public function client_can_create_resturant_service()
    {
        $this->clientApiLogin();
        $this->withoutExceptionHandling();

        $resturant = Resturant::factory()->create();

        $response = $this->post('/api/client/resturantservices', [
            'name' => 'service',
            'resturant_id' => $resturant->id,
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('resturant_services', [
            'name' => 'service',
            'resturant_id' => $resturant->id,
        ]);

    }


    /** @test */
    public function client_can_update_resturant_service()
    {
        $this->clientApiLogin();
        $this->withoutExceptionHandling();

        $resturantService = ResturantService::factory()->create();
        $resturant = Resturant::factory()->create();

        $response = $this->put('/api/client/resturantservices/'. $resturantService->id, [
            'name' => 'update',
            'resturant_id' => $resturant->id,
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('resturant_services', [
            'name' => 'update',
            'resturant_id' => $resturant->id,
        ]);

    }

    /** @test */
    public function client_can_delete_resturant_service()
    {
        $this->clientApiLogin();
        $this->withoutExceptionHandling();

        $resturantService = ResturantService::factory()->create();
        $resturant = Resturant::factory()->create();

        $response = $this->delete('/api/client/resturantservices/'. $resturantService->id);
        $response->assertOk();

        $this->assertSoftDeleted('resturant_services', [
            'id' => $resturantService->id,
        ]);

    }

}





