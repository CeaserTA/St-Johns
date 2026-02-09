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
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfNextWeek = now()->addWeek()->startOfWeek();
        
        // Get events happening this week for the banner (featured section)
        $thisWeekEvents = Event::active()
            ->notExpired()
            ->events() // Only events, not announcements
            ->where(function ($q) use ($startOfWeek, $endOfWeek) {
                // Check starts_at (datetime field)
                $q->where(function ($subQ) use ($startOfWeek, $endOfWeek) {
                    $subQ->whereNotNull('starts_at')
                         ->whereDate('starts_at', '>=', $startOfWeek->toDateString())
                         ->whereDate('starts_at', '<=', $endOfWeek->toDateString());
                })
                // OR check date field (legacy date field)
                ->orWhere(function ($subQ) use ($startOfWeek, $endOfWeek) {
                    $subQ->whereNotNull('date')
                         ->whereDate('date', '>=', $startOfWeek->toDateString())
                         ->whereDate('date', '<=', $endOfWeek->toDateString());
                });
            })
            ->with('creator')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('starts_at', 'asc')
            ->orderBy('date', 'asc')
            ->get();
        
        // Get upcoming events (next week onwards) and all announcements
        // Exclude events happening this week from the main grid
        $events = Event::active()
            ->notExpired()
            ->where(function ($q) use ($startOfNextWeek) {
                // Include all announcements
                $q->where('type', 'announcement')
                  // OR include events from next week onwards
                  ->orWhere(function ($subQ) use ($startOfNextWeek) {
                      $subQ->where('type', 'event')
                           ->where(function ($dateQ) use ($startOfNextWeek) {
                               // Events with starts_at from next week onwards
                               $dateQ->where(function ($sq) use ($startOfNextWeek) {
                                   $sq->whereNotNull('starts_at')
                                      ->whereDate('starts_at', '>=', $startOfNextWeek->toDateString());
                               })
                               // OR events with date from next week onwards
                               ->orWhere(function ($sq) use ($startOfNextWeek) {
                                   $sq->whereNull('starts_at')
                                      ->whereNotNull('date')
                                      ->whereDate('date', '>=', $startOfNextWeek->toDateString());
                               });
                           });
                  });
            })
            ->with('creator')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('starts_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('events', compact('events', 'thisWeekEvents'));
    }

    /**
     * Display the specified event (public detail page).
     */
    public function show(Event $event)
    {
        // Increment view count
        $event->incrementViewCount();
        
        // If it's an AJAX request, return JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'event' => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'type' => $event->type,
                    'description' => $event->description,
                    'content' => $event->content,
                    'location' => $event->location,
                    'date' => $event->date ? $event->date->format('Y-m-d') : null,
                    'time' => $event->time,
                    'starts_at' => $event->starts_at ? $event->starts_at->format('Y-m-d H:i:s') : null,
                    'ends_at' => $event->ends_at ? $event->ends_at->format('Y-m-d H:i:s') : null,
                    'expires_at' => $event->expires_at ? $event->expires_at->format('Y-m-d H:i:s') : null,
                    'formatted_date_time' => $event->formatted_date_time,
                    'formatted_date' => $event->formatted_date,
                    'formatted_time' => $event->formatted_time,
                    'created_at' => $event->created_at->format('Y-m-d H:i:s'),
                    'is_event' => $event->is_event,
                    'is_announcement' => $event->is_announcement,
                ],
            ]);
        }
        
        // Otherwise, return a view (for future use)
        return view('events.show', compact('event'));
    }
}
