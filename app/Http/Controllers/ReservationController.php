<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
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
        $reservations = Reservation::where('user_id', Auth::id())->get();

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

        // Validate incoming data
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'selectedSeats' => 'required|array|min:1'  // Ensure 'selectedSeats' is an array of at least 1 seat
        ]);

        $eventId = $validated['event_id'];
        $selectedSeats = $validated['selectedSeats'];

        // Check if any of the selected seats are already reserved
        $reservedSeats = Reservation::where('event_id', $eventId)
            ->whereIn('seat_numbers', $selectedSeats)  // You can adjust this if structure differs
            ->pluck('seat_numbers')
            ->toArray();

        if (!empty($reservedSeats)) {
            return response()->json([
                'error' => 'Some seats already reserved',
                'reservedSeats' => $reservedSeats
            ], 400);
        }

        // Reserve the selected seats
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
            'seat_numbers' => $selectedSeats,
            'status' => 'confirmed'  // Default to confirmed
        ]);

        return response()->json([
            'message' => 'Seats have been reserved successfully',
            'reservation' => $reservation
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
}
