<?php

namespace Database\Seeders;

use App\Models\Movie;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 1000; $i++) {
            $faker = Factory::create();

            Movie::factory()->create([
                'id' => Str::uuid(),
                'name' => $faker->name,
                'description' => $faker->text,
                'rate' => $faker->numberBetween(0, 5),
                'duration' => $faker->numberBetween(1, 239)
            ]);
        }

    }
}
