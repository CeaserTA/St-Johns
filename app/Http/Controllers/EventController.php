<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events (public page).
     */
    public function index()
    {
        // Get all published events and announcements
        $events = Event::published()
            ->with('creator')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('starts_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('events', compact('events'));
    }

    /**
     * Display the specified event (public detail page).
     */
    public function show(Event $event)
    {
        // Increment view count
        $event->incrementViewCount();
        
        return view('events.show', compact('event'));
    }
}
