<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'related_id',
        'related_type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that this notification belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Scope to get unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Create a new service registration notification
     */
    public static function notifyServiceRegistration($serviceRegistration)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'type' => 'service_registration',
                'title' => 'New Service Registration',
                'message' => 'A new member has registered for a service.',
                'related_id' => $serviceRegistration->id,
                'related_type' => 'ServiceRegistration',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Create a new event registration notification
     */
    public static function notifyEventRegistration($eventRegistration)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'type' => 'event_registration',
                'title' => 'New Event Registration',
                'message' => 'A new member has registered for an event.',
                'related_id' => $eventRegistration->id,
                'related_type' => 'EventRegistration',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Create a new service posted notification
     */
    public static function notifyServicePosted($service)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'type' => 'service_posted',
                'title' => 'New Service Posted',
                'message' => 'A new service has been posted.',
                'related_id' => $service->id,
                'related_type' => 'Service',
                'is_read' => false,
            ]);
        }
    }

    /**
     * Create a new event/announcement posted notification
     */
    public static function notifyEventPosted($event)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'type' => 'event_posted',
                'title' => 'New Event/Announcement Posted',
                'message' => 'A new ' . ($event->type === 'announcement' ? 'announcement' : 'event') . ' has been posted.',
                'related_id' => $event->id,
                'related_type' => 'Event',
                'is_read' => false,
            ]);
        }
    }
}
