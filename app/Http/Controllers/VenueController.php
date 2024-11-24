<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $venues = Venue::where('user_id', Auth::id())->get();

        return Inertia::render('Venues/Index', [
            'venues' => $venues,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Venues/Create', []);
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'location' => 'required|string|max:255',
//            'seat_map' => 'required|json', // Ensure seat map is a valid JSON string
//        ]);

        $user = Auth::user();

        // Create the venue
        $venue = Venue::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'seat_map' => $request->input('seat_map'),
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Venue created successfully!',
            'venue' => $venue,
        ]);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        // Create the venue
        $venue = Venue::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'seat_map' => $request->input('seat_map'),
            'user_id' => $user->id,
        ]);

        // Decode the seat map from JSON to an array
        $seatMap = json_decode($request->seat_map, true);

        // Loop over the seatMap and create seats tied to the event
        foreach ($seatMap as $seat) {
            Seat::create([
                'event_id' => $event->id,  // Link the seat to the event
                'uid' => $seat['id'],      // Use the unique id from the seat_map (parsed)
                'type' => $seat['type'],   // Type of seat: "chair", "table", etc.
                'label' => $seat['label'], // Label like "Chair", "Table", etc.
                'booked' => $seat['booked'], // Whether the seat is booked or not (false by default)
                'x' => $seat['x'],         // X coordinate from the seat map
                'y' => $seat['y'],         // Y coordinate from the seat map
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
