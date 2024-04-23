<?php

namespace Database\Seeders;

use App\Models\Movie;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'name' => $faker->name,
                'description' => $faker->text,
                'released_at' => $faker->date,
                'review' => $faker->numberBetween(0, 5)
            ]);
        }

    }
}
