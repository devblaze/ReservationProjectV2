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
            ->count(10)  // Generate 10 events
            ->has(Seat::factory()->count(30))  // For each event, generate 30 seats
            ->create();

        if (app()->environment('local', 'staging')) {
            $events->searchable();  // Scout indexing
        }
    }
}
