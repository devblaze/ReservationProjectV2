<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Seat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_displays_events()
    {
        Event::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Index')
            ->has('events.data', 5)
            ->has('events.links')
        );
    }

    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->user)->get(route('events.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Create')
        );
    }

    public function test_store_creates_new_event()
    {
        $eventData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('+1 day', '+1 week')->format('Y-m-d\TH:i'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks')->format('Y-m-d\TH:i'),
            'location' => $this->faker->address,
            'seat_map' => json_encode([
                ['id' => 'seat1', 'type' => 'chair', 'label' => 'A1', 'booked' => false, 'x' => 10, 'y' => 20],
                ['id' => 'seat2', 'type' => 'table', 'label' => 'T1', 'booked' => false, 'x' => 30, 'y' => 40],
            ]),
        ];

        $response = $this->actingAs($this->user)->postJson(route('events.store'), $eventData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'event']);
        
        $this->assertDatabaseHas('events', [
            'title' => $eventData['title'],
            'organizer_id' => $this->user->id,
        ]);
        
        $this->assertDatabaseHas('seats', ['uid' => 'seat1']);
        $this->assertDatabaseHas('seats', ['uid' => 'seat2']);
    }

    public function test_show_displays_event_details()
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)->get(route('events.show', $event));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Show')
            ->has('event')
            ->has('canEdit')
        );
    }

    public function test_edit_displays_edit_form()
    {
        $event = Event::factory()->create(['organizer_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('events.edit', $event));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Edit')
            ->has('event')
        );
    }

    public function test_update_modifies_event()
    {
        $event = Event::factory()->create(['organizer_id' => $this->user->id]);
        Seat::factory()->create(['event_id' => $event->id, 'uid' => 'old_seat']);

        $updatedData = [
            'title' => 'Updated Event Title',
            'description' => 'Updated description',
            'start_date' => '2023-07-01T10:00',
            'end_date' => '2023-07-01T12:00',
            'location' => 'Updated Location',
            'seat_map' => json_encode([
                ['id' => 'new_seat', 'type' => 'chair', 'label' => 'A1', 'booked' => false, 'x' => 10, 'y' => 20],
            ]),
        ];

        $response = $this->actingAs($this->user)->putJson(route('events.update', $event), $updatedData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'event']);
        
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event Title',
        ]);
        
        $this->assertDatabaseHas('seats', ['uid' => 'new_seat']);
        $this->assertDatabaseMissing('seats', ['uid' => 'old_seat']);
    }

    public function test_destroy_deletes_event()
    {
        $event = Event::factory()->create(['organizer_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->deleteJson(route('events.destroy', $event));

        $response->assertStatus(200);
        $response->assertJson(['success' => 'Event deleted successfully.']);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    // public function test_upcoming_displays_upcoming_events()
    // {
    //     Event::factory()->count(3)->create([
    //         'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
    //     ]);

    //     $response = $this->actingAs($this->user)->get(route('upcoming_events'));

    //     $response->assertStatus(200);
    //     $response->assertInertia(fn ($assert) => $assert
    //         ->component('Events/Upcoming')
    //         ->has('events')
    //         ->has('search')
    //     );
    // }

    public function test_unauthorized_user_cannot_edit_event()
    {
        $event = Event::factory()->create();
        $unauthorizedUser = User::factory()->create();

        $response = $this->actingAs($unauthorizedUser)->get(route('events.edit', $event));

        $response->assertStatus(403);
    }

    public function test_search_functionality()
    {
        // Create events
        Event::factory()->create(['title' => 'Laravel Conference']);
        Event::factory()->create(['title' => 'PHP Workshop']);

        // Perform search
        $response = $this->actingAs($this->user)
            ->get(route('events.index', ['search' => 'Laravel']));

        // Assert response status
        $response->assertStatus(200);

        // Assert Inertia component and data
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Index')
            ->has('events.data', 1)
            ->where('events.data.0.title', 'Laravel Conference')
        );

        // Perform another search to ensure other events are not included
        $response = $this->actingAs($this->user)
            ->get(route('events.index', ['search' => 'PHP']));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Events/Index')
            ->has('events.data', 1)
            ->where('events.data.0.title', 'PHP Workshop')
        );
    }
}
