<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\MealAddon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealAddonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MealAddon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween($min = 1, $max = 100),
            'meal_id' => Meal::factory()->create()->id,
        ];
    }
}
