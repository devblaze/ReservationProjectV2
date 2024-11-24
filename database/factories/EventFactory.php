<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'organizer_id' => User::factory(),
            'venue_id' => Venue::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('+2 days', '+2 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
//            'location' => $this->faker->address,
            'is_canceled' => $this->faker->boolean,
        ];
    }
}
