<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Seat;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed events with venues and seats
        Event::factory()
            ->count(50)
            ->create()
            ->each(function ($event) {
                $venue = Venue::factory()->create(['user_id' => $event->organizer_id]);
                Seat::factory()
                    ->count(random_int(10, 40))
                    ->create(['venue_id' => $venue->id]);
            });
    }
}
