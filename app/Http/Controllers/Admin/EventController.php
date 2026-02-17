<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of events and announcements
     */
    public function index(Request $request)
    {
        $query = Event::with('creator')->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['event', 'announcement'])) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->inactive();
                    break;
                case 'pinned':
                    $query->pinned();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
            }
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $events = $query->get();

        // Get event registrations for the dashboard
        $registrations = EventRegistration::with('event')
            ->latest()
            ->take(200)
            ->get();

        // Get statistics
        $stats = [
            'total' => Event::count(),
            'events' => Event::events()->count(),
            'announcements' => Event::announcements()->count(),
            'active' => Event::active()->count(),
            'pinned' => Event::pinned()->count(),
            'upcoming' => Event::upcoming()->count(),
        ];

        return view('admin.events_dashboard', compact('events', 'registrations', 'stats'));
    }

    /**
     * Store a newly created event or announcement
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'type' => 'required|in:event,announcement',
                'category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'content' => 'nullable|string',
                'is_active' => 'boolean',
                'is_pinned' => 'boolean',
            ];

            // Type-specific validation
            if ($request->type === 'event') {
                $rules = array_merge($rules, [
                    'date' => 'nullable|date',
                    'time' => 'nullable|string|max:100',
                    'location' => 'nullable|string|max:255',
                    'starts_at' => 'nullable|date',
                    'ends_at' => 'nullable|date|after:starts_at',
                ]);
            }

            if ($request->type === 'announcement') {
                $rules['expires_at'] = 'nullable|date'; // Allow any future date or null
            }

            // Image validation
            if ($request->hasFile('image')) {
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'; // 5MB max
            }

            $validated = $request->validate($rules);

            // Handle image upload to Supabase
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                
                \Log::info('Processing event image upload', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
                
                try {
                    // Generate unique filename
                    $filename = 'event_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Upload to Supabase
                    $path = $file->storeAs('events', $filename, 'supabase');
                    $validated['image'] = $path;
                    
                    \Log::info('Event image uploaded to Supabase successfully', ['path' => $path]);
                    
                } catch (\Exception $e) {
                    \Log::error('Error uploading event image to Supabase', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    
                    // Fall back to local storage if Supabase fails
                    try {
                        $path = $file->store('events', 'public');
                        $validated['image'] = $path;
                        \Log::info('Event image uploaded to local storage as fallback', ['path' => $path]);
                    } catch (\Exception $localError) {
                        \Log::error('Both Supabase and local storage failed for event image', [
                            'supabase_error' => $e->getMessage(),
                            'local_error' => $localError->getMessage()
                        ]);
                        // Continue without image
                        unset($validated['image']);
                    }
                }
            }

            // Set created_by
            $validated['created_by'] = auth()->id();

            // Handle boolean fields (checkboxes)
            $validated['is_active'] = $request->input('is_active', false) ? true : false;
            $validated['is_pinned'] = $request->input('is_pinned', false) ? true : false;

            // For events, populate starts_at from date/time if not provided
            if ($request->type === 'event' && !$request->starts_at && $request->date) {
                $time = $request->time ?? '00:00:00';
                $validated['starts_at'] = $request->date . ' ' . $time;
            }

            $event = Event::create($validated);

            $typeName = $request->type === 'event' ? 'Event' : 'Announcement';
            
            \Log::info("Event created successfully", [
                'id' => $event->id,
                'title' => $event->title,
                'type' => $event->type,
                'is_active' => $event->is_active
            ]);
            
            return redirect()->route('admin.events')->with('success', "{$typeName} created successfully.");
            
        } catch (\Exception $e) {
            \Log::error("Error creating event", [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()->with('error', 'Error creating event: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified event or announcement
     */
    public function show(Event $event)
    {
        $event->load('creator', 'registrations');
        $event->incrementViewCount();

        return response()->json([
            'success' => true,
            'event' => $event,
        ]);
    }

    /**
     * Update the specified event or announcement
     */
    public function update(Request $request, Event $event)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:event,announcement',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
        ];

        // Type-specific validation
        if ($request->type === 'event') {
            $rules = array_merge($rules, [
                'date' => 'nullable|date',
                'time' => 'nullable|string|max:100',
                'location' => 'nullable|string|max:255',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after:starts_at',
            ]);
        }

        if ($request->type === 'announcement') {
            $rules['expires_at'] = 'nullable|date';
        }

        // Image validation
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'; // 5MB max
        }

        $validated = $request->validate($rules);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            \Log::info('Processing event image update', [
                'event_id' => $event->id,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
            
            try {
                // Delete old image from Supabase if exists
                if ($event->image) {
                    try {
                        Storage::disk('supabase')->delete($event->image);
                        \Log::info('Old event image deleted from Supabase', ['path' => $event->image]);
                    } catch (\Exception $e) {
                        \Log::warning('Could not delete old event image from Supabase', [
                            'path' => $event->image,
                            'error' => $e->getMessage()
                        ]);
                        
                        // Try deleting from local storage as fallback
                        if (Storage::disk('public')->exists($event->image)) {
                            Storage::disk('public')->delete($event->image);
                            \Log::info('Old event image deleted from local storage');
                        }
                    }
                }
                
                // Generate unique filename
                $filename = 'event_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Upload new image to Supabase
                $path = $file->storeAs('events', $filename, 'supabase');
                $validated['image'] = $path;
                
                \Log::info('New event image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading event image to Supabase', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                // Fall back to local storage
                try {
                    $path = $file->store('events', 'public');
                    $validated['image'] = $path;
                    \Log::info('Event image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Both Supabase and local storage failed for event image', [
                        'supabase_error' => $e->getMessage(),
                        'local_error' => $localError->getMessage()
                    ]);
                    // Continue without updating image
                    unset($validated['image']);
                }
            }
        }

        // Handle boolean fields (checkboxes)
        $validated['is_active'] = $request->input('is_active', false) ? true : false;
        $validated['is_pinned'] = $request->input('is_pinned', false) ? true : false;

        // For events, populate starts_at from date/time if not provided
        if ($request->type === 'event' && !$request->starts_at && $request->date) {
            $time = $request->time ?? '00:00:00';
            $validated['starts_at'] = $request->date . ' ' . $time;
        }

        $event->update($validated);

        $typeName = $request->type === 'event' ? 'Event' : 'Announcement';
        return redirect()->route('admin.events')->with('success', "{$typeName} updated successfully.");
    }

    /**
     * Remove the specified event or announcement
     */
    public function destroy(Event $event)
    {
        // Delete image from Supabase if exists
        if ($event->image) {
            try {
                Storage::disk('supabase')->delete($event->image);
                \Log::info('Event image deleted from Supabase', ['path' => $event->image]);
            } catch (\Exception $e) {
                \Log::warning('Could not delete event image from Supabase', [
                    'path' => $event->image,
                    'error' => $e->getMessage()
                ]);
                
                // Try deleting from local storage as fallback
                if (Storage::disk('public')->exists($event->image)) {
                    Storage::disk('public')->delete($event->image);
                    \Log::info('Event image deleted from local storage');
                }
            }
        }

        $typeName = $event->is_event ? 'Event' : 'Announcement';
        $event->delete();

        return redirect()->route('admin.events')->with('success', "{$typeName} deleted successfully.");
    }

    /**
     * Toggle pin status
     */
    public function togglePin(Event $event)
    {
        if ($event->is_pinned) {
            $event->unpin();
            $message = 'Unpinned successfully.';
        } else {
            $event->pin();
            $message = 'Pinned successfully.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_pinned' => $event->is_pinned,
        ]);
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Event $event)
    {
        if ($event->is_active) {
            $event->deactivate();
            $message = 'Deactivated successfully.';
        } else {
            $event->activate();
            $message = 'Activated successfully.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_active' => $event->is_active,
        ]);
    }

    /**
     * Set expiration date
     */
    public function setExpiration(Request $request, Event $event)
    {
        $validated = $request->validate([
            'expires_at' => 'required|date|after:now',
        ]);

        $event->setExpiration($validated['expires_at']);

        return response()->json([
            'success' => true,
            'message' => 'Expiration date set successfully.',
            'expires_at' => $event->expires_at,
        ]);
    }

    /**
     * Remove expiration date
     */
    public function removeExpiration(Event $event)
    {
        $event->removeExpiration();

        return response()->json([
            'success' => true,
            'message' => 'Expiration date removed successfully.',
        ]);
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:events,id',
        ]);

        $events = Event::whereIn('id', $validated['ids'])->get();

        foreach ($events as $event) {
            // Delete images from Supabase
            if ($event->image) {
                try {
                    Storage::disk('supabase')->delete($event->image);
                } catch (\Exception $e) {
                    \Log::warning('Could not delete event image from Supabase during bulk delete', [
                        'event_id' => $event->id,
                        'path' => $event->image,
                        'error' => $e->getMessage()
                    ]);
                    
                    // Try local storage as fallback
                    if (Storage::disk('public')->exists($event->image)) {
                        Storage::disk('public')->delete($event->image);
                    }
                }
            }
            $event->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' items deleted successfully.',
        ]);
    }

    /**
     * Bulk activate
     */
    public function bulkActivate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:events,id',
        ]);

        Event::whereIn('id', $validated['ids'])->update(['is_active' => true]);

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' items activated successfully.',
        ]);
    }

    /**
     * Bulk deactivate
     */
    public function bulkDeactivate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:events,id',
        ]);

        Event::whereIn('id', $validated['ids'])->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' items deactivated successfully.',
        ]);
    }

    /**
     * Bulk pin
     */
    public function bulkPin(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:events,id',
        ]);

        Event::whereIn('id', $validated['ids'])->update(['is_pinned' => true]);

        return response()->json([
            'success' => true,
            'message' => count($validated['ids']) . ' items pinned successfully.',
        ]);
    }
}
