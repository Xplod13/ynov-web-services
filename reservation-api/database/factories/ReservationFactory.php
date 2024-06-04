<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rank' => fake()->numberBetween(0),
            'status' => fake()->randomElement(['open', 'expired', 'confirmed']),
            'seats' => fake()->numberBetween(1),
            'expires_at' => Carbon::now()->addHours(6),
        ];
    }
}
