<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Seat;
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
            'uid' => $this->faker->uuid(), // Generate a UID for the seats of the event
            'event_id' => Event::factory(), // Assuming you also created event factory
            'type' => $this->faker->randomElement($types),  // 'table' or 'chair'
            'label' => $this->faker->randomElement($types),  // 'table' or 'chair'
            'booked' => $this->faker->boolean(20),  // 20% chance a seat is booked
            'x' => $this->faker->numberBetween(50, 800),  // X-coordinate randomly assigned
            'y' => $this->faker->numberBetween(50, 800),  // Y-coordinate randomly assigned
        ];
    }
}
