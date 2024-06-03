<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seance>
 */
class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => Movie::factory()->create([
                'name' => fake()->name,
                'description' => fake()->text(4096),
                'rate' => fake()->numberBetween(0, 5),
                'duration' => fake()->numberBetween(1, 239)
            ])->id,
            'date' => now()
        ];
    }
}
