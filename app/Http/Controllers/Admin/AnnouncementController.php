<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * @deprecated This controller is deprecated. Use EventController instead.
 * 
 * Announcements have been merged into the Event model.
 * All announcement functionality is now handled by EventController.
 * 
 * This class is kept for backward compatibility only.
 */
class AnnouncementController extends Controller
{
    public function index()
    {
        // Redirect to events dashboard with announcement filter
        return redirect()->route('admin.events', ['type' => 'announcement']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'created_by' => 'nullable|string|max:255',
        ]);

        // Create as announcement type in events table
        Event::create([
            'title' => $validated['title'],
            'content' => $validated['message'],
            'description' => substr($validated['message'], 0, 500),
            'type' => Event::TYPE_ANNOUNCEMENT,
            'category' => Event::CATEGORY_GENERAL,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.events', ['type' => 'announcement'])
            ->with('success', 'Announcement created successfully.');
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'created_by' => 'nullable|string|max:255',
        ]);

        $event->update([
            'title' => $validated['title'],
            'content' => $validated['message'],
            'description' => substr($validated['message'], 0, 500),
        ]);

        return redirect()->route('admin.events', ['type' => 'announcement'])
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events', ['type' => 'announcement'])
            ->with('success', 'Announcement deleted successfully.');
    }
}
