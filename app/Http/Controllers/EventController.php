<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $events = Event::search($request->query('q'))->get();

        return inertia('Events/Index', [
            'events' => $events,
        ]);
    }

    public function create(): Response
    {
        return inertia('Events/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'seats' => 'required|numeric',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'venue_id' => 'required|exists:venues,id',
        ]);

        $event = Event::create($validatedData);

        return redirect()->route('events.show', $event);
    }

    public function show(Event $event): Response
    {
        return inertia('Events/Show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event): Response
    {
        return inertia('Events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'seats' => 'required|numeric',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'venue_id' => 'required|exists:venues,id',
        ]);

        $event->update($validatedData);

        return redirect()->route('events.show', $event);
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
