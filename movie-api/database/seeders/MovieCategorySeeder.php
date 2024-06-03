<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\MovieCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MovieCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $movies = Movie::all();

        foreach ($movies as &$movie) {
            $randomCategory = rand(0, $categories->count() - 1);

            if (!MovieCategory::where([['movie_id', $movie->id], ['category_id', $categories[$randomCategory]->id]])->exists()) {
                MovieCategory::factory()->create([
                    'id' => Str::uuid(),
                    'movie_id' => $movie->id,
                    'category_id' => $categories[$randomCategory]->id,
                ]);
            }

            if (rand(0, 1)) {

                $oneOtherRandomCategory = rand(0, $categories->count() - 1);

                if (!MovieCategory::where([['movie_id', $movie->id], ['category_id', $categories[$oneOtherRandomCategory]->id]])->exists()) {
                    MovieCategory::factory()->create([
                        'id' => Str::uuid(),
                        'movie_id' => $movie->id,
                        'category_id' => $categories[$oneOtherRandomCategory]->id,
                    ]);
                }

            }
        }
    }
}
