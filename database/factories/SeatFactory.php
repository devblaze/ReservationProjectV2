<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    protected $model = Seat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['table', 'chair'];
        return [
            'uid' => $this->faker->uuid(), // Generate a UID for the seat
            'venue_id' => Venue::factory(), // Associate seat with a venue
            'type' => $this->faker->randomElement($types),  // 'table' or 'chair'
            'label' => $this->faker->word(),  // Random label
            'booked' => $this->faker->boolean(20),  // 20% chance a seat is booked
            'x' => $this->faker->numberBetween(10, 1080),  // X-coordinate randomly assigned
            'y' => $this->faker->numberBetween(10, 340),   // Y-coordinate randomly assigned
        ];
    }
}
