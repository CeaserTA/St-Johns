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
        $events = Event::orderBy('date', 'asc')->get();
        return view('events', compact('events'));
    }

    /**
     * Display the specified event (public detail page).
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
