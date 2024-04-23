<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::get()
        $movies = Movie::get()
        foreach ($movies as &$movie) {
            $randomCategory = array_rand($categories);
            MovieCategory::factory()->create([
                'movie_id' => $movie->id,
                'category_id' => $categories[$randomCategory]->id,
            ]);
            if (rand(0, 1)) {
                $oneOtherRandomCategory = array_rand($categories);
                MovieCategory::factory()->create([
                    'movie_id' => $movie->id,
                    'category_id' => $categories[$oneOtherRandomCategory]->id,
                ]);
            }
        }
    }
}
