<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Keygen\Keygen;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->e164PhoneNumber,
            'country' => $this->faker->country,
            'job' => config('constants.roles.1'),
            'identity_no' => $this->faker->randomNumber,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the client is verified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'verified' => Client::YES,
            ];
        });
    }

    /**
     * Indicate that the client is notVerified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function notVerified()
    {
        return $this->state(function (array $attributes) {
            return [
                'verified' => Client::NO,
                'verification_code' => Keygen::numeric(6)->generate(),
            ];
        });
    }


}



