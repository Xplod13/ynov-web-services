<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use Faker\Factory;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();

            Category::factory()->create([
                'id' => Str::uuid(),
                'name' => $faker->name,
            ]);
        }
    }
}
