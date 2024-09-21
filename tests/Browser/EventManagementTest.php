<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventManagementTest extends DuskTestCase
{
    // Declare the class properties to store event names
    protected $eventName;
    protected $updatedEventName;

    // You can define the events names in the setUp method
    protected function setUp(): void
    {
        parent::setUp();

        // Initialize your event names once for reuse in tests
        $this->eventName = 'Party for Roulis ' . time();             // Dynamic event name based on timestamp
        $this->updatedEventName = 'Updated Party for Roulis ' . time(); // Dynamic updated event name
    }

    /**
     * Test admin creates an event with a seat map and verify.
     */
    public function testAdminCreatesEventAndVerifiesSeatMap()
    {
        $this->browse(function (Browser $browser) {
            // Step 0: Manually log in with specific email and password
            $browser->visit('/login')
                ->type('email', 'admin@admin')  // Enter the email
                ->pause(2000)                   // Slow down the process for visibility
                ->type('password', 'admin')     // Enter the password
                ->pause(2000)                   // Again slow down
                ->press('Login')                // Press the login button
                ->assertPathIs('/home');        // Ensure we're redirected to `/home`

            // Step 1: Create Event
            $browser->visit('/events/create')
                ->type('#title', $this->eventName)  // Use $this->eventName now
                ->type('#description', 'Party of Roulis with other cats')
                ->type('#start_date', '2024-10-30T03:00')
                ->type('#end_date', '2024-10-31T03:00')
                ->type('#location', 'Ioannina, Greece')

                // Add chairs and table
                ->click('.btn.bg-blue-500:contains("Add Chair")')
                ->click('.btn.bg-blue-500:contains("Add Chair")')
                ->click('.btn.bg-blue-500:contains("Add Table")')

                // Move the items
                ->drag('.canvas .chair:nth-child(1)', 100, 100)
                ->drag('.canvas .chair:nth-child(2)', 200, 200)
                ->drag('.canvas .table', 300, 300)

                // Submit event creation and verify success
                ->click('.mt-4')
                ->waitForText('Event created successfully!')
                ->assertPathIs('/events')

                // Step 2: Verify Event Creation and Seat Map
                ->visit('/events')
                ->type('#search-dropdown', $this->eventName)
                ->click('.event-name:contains("'.$this->eventName.'")');

            // Verify Chair and Table positions post-creation
            $browser->assertSourceHas('left: 7px; top: 32px;') // For the first chair
            ->assertSourceHas('left: 107px; top: 132px;'); // For the second chair
        });
    }

    /**
     * Test admin edits an event and verifies.
     */
    public function testAdminEditsEventAndVerifies()
    {
        $this->browse(function (Browser $browser) {
            // Step 1: Edit Event
            $browser->visit('/events')
                ->type('#search-dropdown', $this->eventName)  // Reference $this->eventName
                ->click('.event-name:contains("'.$this->eventName.'")')
                ->click('#edit-event-button')
                ->type('#title', $this->updatedEventName)  // Use $this->updatedEventName

                // Add new chair in unique position
                ->click('.btn.bg-blue-500:contains("Add Chair")')
                ->drag('.canvas .chair:last-child', 400, 400)

                // Verify that 3 chairs now exist
                ->assertElementsCount('.canvas .chair', 3)
                ->press('#save-changes-button')
                ->waitForText('Event updated successfully!')
                ->assertPathIs('/events')

                // Step 2: Verify Updated Event Title & Seat Map
                ->visit('/events')
                ->type('#search-dropdown', $this->updatedEventName)  // Search updated title
                ->click('.event-name:contains("'.$this->updatedEventName.'")');

            // Verify updated seat map
            $browser->assertSourceHas('left: 307px; top: 326px;'); // For the newly added chair
        });
    }

    /**
     * Test admin deletes an event.
     */
    public function testAdminDeletesEvent()
    {
        $this->browse(function (Browser $browser) {
            // Step 1: Delete Event
            $browser->visit('/events')
                ->type('#search-dropdown', $this->updatedEventName)  // Reference $this->updatedEventName
                ->click('.event-name:contains("'.$this->updatedEventName.'")')
                ->click('.delete-event-button')
                ->waitFor('.delete-event-confirm')
                ->click('.delete-event-confirm')
                ->waitForText('Event deleted successfully!')
                ->assertPathIs('/events')

                // Step 2: Verify Deletion
                ->visit('/events')
                ->type('#search-dropdown', $this->updatedEventName)
                ->assertDontSee($this->updatedEventName);
        });
    }
}
