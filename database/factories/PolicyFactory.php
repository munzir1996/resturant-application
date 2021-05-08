<?php

namespace Database\Factories;

use App\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Policy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'terms' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'accept' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        ];
    }
}
