<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;
use App\Models\Seat;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function index(Request $request): Response|JsonResponse
    {
        $search = $request->input('search', '');
        $events = Event::search($search)->paginate(16);

        $events->getCollection()->transform(function ($event) {
            $event->url = route('events.show', $event->id);
            return $event;
        });

        // Check if it's an API request, and return JSON data if so
        if ($request->wantsJson()) {
            return response()->json($events);
        }

        // Otherwise, render the Inertia.js page
        return Inertia::render('Events/Index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for creating a new event.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Events/Create');
    }

    /**
     * Store a newly created event in storage.
     *
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function store(EventRequest $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        // Create a new event with the validated data
        $event = Event::create([
            'organizer_id' => $user->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'location' => $request->input('location'),
            'is_canceled' => false,
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

        return response()->json(['message' => 'Event and seats created successfully!', 'event' => $event]);
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event): Response
    {
        $user = Auth::user();

        $canEdit = $user ? $user->can('update', $event) : false;
        $event->seat_map = $event->generateSeatMap();

        return Inertia::render('Events/Show', [
            'event' => $event,
            'canEdit' => $canEdit,
        ]);
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param Event $event
     * @return Response
     */
    public function edit(Event $event): Response
    {
        $this->authorize('update', $event);

        $event->seat_map = $event->generateSeatMap();

        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified event in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(Request $request, Event $event) : JsonResponse
    {
        // Validate the request data
//        $validated = $request->validate([
//            'title' => 'required|string|max:255',
//            'description' => 'required|string',
//            'start_date' => 'required|date_format:Y-m-d\TH:i',
//            'end_date' => 'required|date_format:Y-m-d\TH:i',
//            'location' => 'required|string|max:255',
//            'seat_map' => 'required|json',  // Expect seat_map to be passed as a JSON array
//        ]);

        // Ensure the user is authorized to update the event (optional, based on auth logic)
        if ($event->organizer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized action'], 403);
        }

        // Update the event details
        $event->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'location' => $request['location'],
        ]);

        // Decode the seat map from JSON to an array
        $seatMap = json_decode($request['seat_map'], true);

        // Fetch the existing seat IDs from the database, associated with this event
        $existingSeatIds = $event->seats->pluck('uid')->toArray();

        // Prepare a new list of seat IDs from the incoming seat map
        $incomingSeatIds = array_column($seatMap, 'id');

        // Handle seat changes (i.e. create new seats or update existing seats)

        foreach ($seatMap as $seatData) {
            // Check if the seat already exists by its unique 'uid'
            $seat = Seat::where('uid', $seatData['id'])->where('event_id', $event->id)->first();

            if ($seat) {
                // Update existing seat
                $seat->update([
                    'type' => $seatData['type'],
                    'label' => $seatData['label'],
                    'booked' => $seatData['booked'],
                    'x' => $seatData['x'],
                    'y' => $seatData['y'],
                ]);
            } else {
                // Create new seat
                Seat::create([
                    'event_id' => $event->id,
                    'uid' => $seatData['id'],
                    'type' => $seatData['type'],
                    'label' => $seatData['label'],
                    'booked' => $seatData['booked'],
                    'x' => $seatData['x'],
                    'y' => $seatData['y'],
                ]);
            }
        }

        // Remove seats that are no longer in the updated seat map
        $seatsToDelete = array_diff($existingSeatIds, $incomingSeatIds);
        Seat::whereIn('uid', $seatsToDelete)->where('event_id', $event->id)->delete();

        // Return the success response
        return response()->json([
            'message' => 'Event and seats updated successfully!',
            'event' => $event,
        ]);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json(['success' => 'Event deleted successfully.']);
    }

    /**
     * Display a listing of the upcoming events.
     *
     * @param Request $request
     * @return Response
     */
    public function upcoming(Request $request): Response
    {
        $search = $request->input('search', '');
        $events = Event::where('date', '>=', today())
            ->search($search)
            ->orderBy('date', 'asc')
            ->paginate();
        return Inertia::render('Events/Upcoming', [
            'events' => $events,
            'search' => $search,
        ]);
    }
}

