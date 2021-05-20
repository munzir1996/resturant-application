<?php

namespace Database\Factories;

use App\Models\Resturant;
use App\Models\ResturantService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResturantServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResturantService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'resturant_id' => Resturant::factory()->create()->id,
        ];
    }
}
