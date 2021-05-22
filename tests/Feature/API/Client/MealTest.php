<?php

namespace Tests\Feature\API\Client;

use App\Models\Classification;
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

    /** @test */
    public function client_can_add_a_meal()
    {
        $this->clientApiLogin();

        $classification = Classification::factory()->create();

        $response = $this->post('api/client/meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => 'small',
            'additions' => 'extra',
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => 'small',
            'additions' => 'extra',
        ]);
    }

    /** @test */
    public function client_can_edit_a_meal()
    {
        $this->clientApiLogin();

        $meal = Meal::factory()->create();
        $classification = Classification::factory()->create();

        $response = $this->put('api/client/meals/'. $meal->id, [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => 'small',
            'additions' => 'extra',
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => 'small',
            'additions' => 'extra',
        ]);
    }

    /** @test */
    public function client_can_delete_a_meal()
    {
        $this->clientApiLogin();

        $meal = Meal::factory()->create();

        $response = $this->delete('api/client/meals/'. $meal->id);
        $response->assertOk();

        $this->assertSoftDeleted('meals', [
            'id' => $meal->id,
        ]);
    }

}


