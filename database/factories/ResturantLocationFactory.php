<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Resturant;
use App\Models\ResturantLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResturantLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResturantLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'latitude' => $this->faker->latitude,
            'longetitue' => $this->faker->longitude,
            'resturant_id' => Resturant::factory()->create()->id,
        ];
    }
}
