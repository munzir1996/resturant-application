<?php

namespace Database\Factories;

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
            'name_en' => $this->faker->name,
            'manager_name' => $this->faker->name,
            'manager_phone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'commercial_registration_no' => Keygen::numeric(6)->generate(),
            'open_time' => '8am',
            'close_time' => '10pm',
            'client_id' => Client::factory()->create()->id,
            'services' => [1,2,3],
            'maximum_delivery_distance' => $this->faker->numberBetween($min = 1, $max = 100),
            'neighborhood_delivery_price' => $this->faker->numberBetween($min = 1, $max = 100),
            'outside_neighborhood_delivery_price' => $this->faker->numberBetween($min = 1, $max = 100),
            'minimum_purchase_free_delivery_in_neighborhood' => $this->faker->numberBetween($min = 1, $max = 100),
            'minimum_purchase_free_delivery_outside_neighborhood' => $this->faker->numberBetween($min = 1, $max = 100),
            'accepted_payment_methods' => [1,2],
            'loyalty_points' => Resturant::YES,
            'customer_earn_points' => $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }

}
