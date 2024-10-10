<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Load the event together with the reservations
        $reservations = Reservation::with('event') // Ensure 'event' relationship is eager-loaded
        ->where('user_id', Auth::id())
            ->get();

        // Check if it's an API request, and return JSON data if so
        if ($request->wantsJson()) {
            return response()->json($reservations);
        }

        // Otherwise, render the Inertia.js page
        return Inertia::render('Reservations/Index', [
            'reservations' => $reservations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'selectedSeats' => 'required|array|min:1',  // Ensure selectedSeats contains seat `uid` values
        ]);

        $eventId = $validated['event_id'];

        // Extract seat UIDs from request
        $selectedSeatUids = array_map(function ($seat) {
            return $seat['id'];  // ID here refers to the frontend-generated uid
        }, $validated['selectedSeats']);

        // Check if any of the selected seats are already reserved
        $reservedSeats = Reservation::where('event_id', $eventId)
            ->whereIn('seat_id', $selectedSeatUids)  // Using seat UIDs here
            ->pluck('seat_id')
            ->toArray();

        if (!empty($reservedSeats)) {
            return response()->json([
                'error' => 'Some seats already reserved',
                'reservedSeats' => $reservedSeats,
            ], 400);
        }

        // Reserve the selected seats
        foreach ($selectedSeatUids as $seatUid) {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'seat_id' => $seatUid,  // Assign the seat UID as the foreign key
                'status' => 'confirmed',
            ]);
        }

        return response()->json([
            'message' => 'Seats reserved successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function cancel(Request $request, Reservation $reservation)
    {
        // Check if the reservation is not already cancelled
        if ($reservation->status === 'cancelled') {
            return back()->withErrors(['message' => 'Reservation is already cancelled.']);
        }

        // Cancel the reservation by updating its status
        $reservation->update([
            'status' => 'cancelled',
        ]);

        return response()->json(['message' => 'Reservation cancelled successfully.']);
    }
}
