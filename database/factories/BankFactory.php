<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Resturant;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->bank,
            'iban' => $this->faker->iban(null),
            'resturant_id' => Resturant::factory()->create()->id,
        ];
    }
}
