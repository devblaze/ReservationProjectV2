<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed an event and attach seats to it
        $events = Event::factory()
            ->count(50)  // Generate 50 events
            ->has(Seat::factory()->count(rand(10, 40)))  // For each event, generate between 10 and 40 seats
            ->create();

        if (app()->environment('local', 'staging')) {
            $events->searchable();  // Scout indexing
        }
    }
}
