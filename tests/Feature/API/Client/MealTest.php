<?php

namespace Tests\Feature\API\Client;

use App\Models\Meal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MealTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function client_can_get_all_meals()
    {
        $this->clientApiLogin();

        Meal::factory()->create();

        $response = $this->get('/api/client/meals');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'classification_id',
                    'price',
                    'detail',
                    'calorie',
                    'size',
                    'additions',
                ]
            ]
        ]);
    }

    /** @test */
    public function client_can_get_selected_meals()
    {
        $this->clientApiLogin();

        $meal = Meal::factory()->create();

        $response = $this->get('/api/client/meals/'. $meal->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'classification_id',
                'price',
                'detail',
                'calorie',
                'size',
                'additions',
            ]
        ]);
    }

}


