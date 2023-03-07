<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $venue = Venue::inRandomOrder()->first();

        return [
            'title' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'seats' => $this->faker->numberBetween(50, 200),
            'seats_left' => $this->faker->numberBetween(0, 50),
            'seat_map' => json_encode([
                'A' => ['1', '2', '3'],
                'B' => ['1', '2', '3'],
                'C' => ['1', '2', '3'],
            ]),
            'venue_id' => $venue->id,
            'start_time' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'end_time' => $this->faker->dateTimeBetween('+2 week', '+3 week'),
        ];
    }
}
