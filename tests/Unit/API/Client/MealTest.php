<?php

namespace Tests\Unit\API\Client;

use Tests\TestCase;
use App\AdjustGroup;
use App\AdjustStandar;
use App\Models\Meal;
use App\Models\MealAddon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_store_meal_addons()
    {
        $mealAddons = [
            [
                'name' => 'addon1',
                'price' => 10,
            ],
        ];

        $meal = Meal::factory()->create();
        $meal->storeMealAddons($mealAddons);

        $this->assertDatabaseHas('meal_addons', [
            'name' => 'addon1',
            'price' => 10,
        ]);
    }

    /** @test */
    public function can_update_meal_addons()
    {
        $mealAddons = [
            [
                'name' => 'addon1',
                'price' => 10,
            ],
        ];

        $meal = Meal::factory()->create();
        MealAddon::factory(2)->create([
            'meal_id' => $meal->id,
        ]);

        $meal->updateMealAddons($mealAddons);

        $this->assertDatabaseHas('meal_addons', [
            'name' => 'addon1',
            'price' => 10,
        ]);
    }

}
