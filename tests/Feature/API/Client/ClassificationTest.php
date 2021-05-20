<?php

namespace Tests\Feature\API\Client;

use App\Models\Classification;
use App\Models\Resturant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_get_all_classifications_services()
    {
        $this->clientApiLogin();

        Classification::factory()->create();

        $response = $this->get('/api/client/classifications');
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
    public function client_can_get_selected_classification_service()
    {

        $this->clientApiLogin();

        $classification = Classification::factory()->create();

        $response = $this->get('/api/client/classifications/'. $classification->id);
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

        $classification = Classification::factory()->create();

        $response = $this->post('/api/client/classifications', [
            'name' => 'service',
            'resturant_id' => $classification->id,
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('classifications', [
            'name' => 'service',
            'resturant_id' => $classification->id,
        ]);

    }


    /** @test */
    public function client_can_update_classification()
    {
        $this->clientApiLogin();

        $classification = Classification::factory()->create();
        $resturant = Resturant::factory()->create();

        $response = $this->put('/api/client/classifications/'. $classification->id, [
            'name' => 'update',
            'resturant_id' => $resturant->id,
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('classifications', [
            'name' => 'update',
            'resturant_id' => $resturant->id,
        ]);

    }

    /** @test */
    public function client_can_delete_resturant_service()
    {
        $this->clientApiLogin();

        $classification = Classification::factory()->create();
        $resturant = Resturant::factory()->create();

        $response = $this->delete('/api/client/classifications/'. $classification->id);
        $response->assertOk();

        $this->assertSoftDeleted('classifications', [
            'id' => $classification->id,
        ]);

    }

}
