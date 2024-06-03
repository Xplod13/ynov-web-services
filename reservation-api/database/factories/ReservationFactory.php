<?php

namespace Database\Factories;

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
        ];
    }
}
