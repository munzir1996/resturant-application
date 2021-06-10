<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bank;
use App\Models\Category;
use App\Models\City;
use App\Models\Classification;
use App\Models\Client;
use App\Models\Meal;
use App\Models\Policy;
use App\Models\Resturant;
use App\Models\ResturantLocation;
use App\Models\ResturantService;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Keygen\Keygen;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Subcategory::factory(10)->create();
        $client = Client::factory()->create([
            'name' => 'client',
            'email' => 'client@client.com',
            'phone' => '0555555555',
            'country' => 'Saudi Arabia',
            'job' => config('constants.roles.1'),
            'identity_no' => '111',
            // $table->string('')->default(Client::NO);
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $resturant = Resturant::factory()->create([
            'client_id' => $client->id,
        ]);
        ResturantService::factory(5)->create([
            'resturant_id' => $resturant->id,
        ]);
        Bank::factory(2)->create([
            'resturant_id' => $resturant->id,
        ]);
        $classification = Classification::factory()->create([
            'resturant_id' => $resturant->id,
        ]);
        Meal::factory(10)->create([
            'classification_id' => $classification->id,
        ]);
        $city = City::factory()->create();
        ResturantLocation::factory()->create([
            'resturant_id' => $resturant->id,
        ]);
        Policy::factory()->create();

    }
}




