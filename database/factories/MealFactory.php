<?php

namespace Database\Factories;

use App\Models\Classification;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'classification_id' => Classification::factory()->create()->id,
            'price' => $this->faker->numberBetween($min = 1, $max = 100),
            'detail' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'calorie' => $this->faker->numberBetween($min = 1, $max = 100),
            'size' => $this->faker->name,
            'tax' => $this->faker->numberBetween($min = 1, $max = 100),
            'points' => $this->faker->numberBetween($min = 1, $max = 100),
        ];
    }
}
