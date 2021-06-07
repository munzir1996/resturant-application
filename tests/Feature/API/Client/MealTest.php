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
                    'meal_addons',
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
                'meal_addons',
            ]
        ]);
    }

    /** @test */
    public function client_can_add_a_meal()
    {
        $this->withoutExceptionHandling();
        $this->clientApiLogin();

        $mealAddons = [
            [
                'name' => 'addon1',
                'price' => 10,
            ],
            [
                'name' => 'addon2',
                'price' => 20,
            ],
        ];
        $classification = Classification::factory()->create();

        $response = $this->post('api/client/meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => 1,
            'tax' => 5,
            'points' => 1,
            'meal_addons' => $mealAddons,
        ]);
        $response->assertCreated();

        $this->assertDatabaseHas('meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => config('constants.meal_sizes.1'),
            'tax' => 5,
            'points' => 1,
        ]);
        $this->assertDatabaseHas('meal_addons', [
            'name' => 'addon2',
            'price' => 20,
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
            'size' => 1,
            'tax' => 10,
            'points' => 1,
        ]);
        $response->assertOk();

        $this->assertDatabaseHas('meals', [
            'name' => 'name',
            'classification_id' => $classification->id,
            'price' => 100,
            'detail' => 'detail',
            'calorie' => 25,
            'size' => config('constants.meal_sizes.1'),
            'tax' => 10,
            'points' => 1,
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


