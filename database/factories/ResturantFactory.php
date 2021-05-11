<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Client;
use App\Models\Resturant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Keygen\Keygen;

class ResturantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resturant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_ar' => $this->faker->name,
            'commercial_registration_no' => Keygen::numeric(6)->generate(),
            'open_time' => '8am',
            'close_time' => '10pm',
            'delivery' => Resturant::NO,
            'client_id' => Client::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
        ];
    }

}
