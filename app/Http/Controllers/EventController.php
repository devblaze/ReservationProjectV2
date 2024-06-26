<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;
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
            'seat_map' => $request->input('seat_map'),
        ]);

        return response()->json(['message' => 'Event created!', 'event' => $event]);
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event): Response
    {
        $seatMap = $event->seat_map ? json_decode($event->seat_map, true) : [];
        $user = Auth::user();

        $canEdit = $user ? $user->can('update', $event) : false;

        return Inertia::render('Events/Show', [
            'event' => $event,
            'seatMap' => $seatMap,
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

        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified event in storage.
     *
     * @param EventRequest $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(EventRequest $request, Event $event): JsonResponse
    {
        $event->update($request->validated());

        return response()->json(['success' => 'Event updated successfully.']);
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

