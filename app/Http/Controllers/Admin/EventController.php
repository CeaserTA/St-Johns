<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->get();
        return view('admin.events_dashboard', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Event::create($validated);

        return redirect()->route('admin.events')->with('success', 'Event created successfully.');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
    }
}
