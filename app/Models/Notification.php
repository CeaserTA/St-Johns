<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Helper for creating database notifications using Laravel's
 * standard `notifications` table structure (uuid, notifiable_*, data, read_at).
 */
class Notification
{
    /**
     * Insert one row into the notifications table for a given admin user.
     *
     * This uses the new Laravel-style schema:
     * - id (uuid)
     * - type (string)
     * - notifiable_id (bigint)
     * - notifiable_type (string)
     * - data (JSON string)
     * - read_at (timestamp|null)
     * - created_at / updated_at (timestamps)
     */
    protected static function insertForAdmin(User $admin, string $type, array $data): void
    {
        DB::table('notifications')->insert([
            'id' => (string) Str::uuid(),
            'type' => $type,
            'notifiable_id' => $admin->id,
            'notifiable_type' => User::class,
            'data' => json_encode($data),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Create a new service registration notification
     */
    public static function notifyServiceRegistration($serviceRegistration): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::insertForAdmin($admin, 'service_registration', [
                'title' => 'New Service Registration',
                'message' => 'A new member has registered for a service.',
                'related_id' => $serviceRegistration->id,
                'related_type' => 'ServiceRegistration',
            ]);
        }
    }

    /**
     * Create a new event registration notification
     */
    public static function notifyEventRegistration($eventRegistration): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::insertForAdmin($admin, 'event_registration', [
                'title' => 'New Event Registration',
                'message' => 'A new member has registered for an event.',
                'related_id' => $eventRegistration->id,
                'related_type' => 'EventRegistration',
            ]);
        }
    }

    /**
     * Create a new service posted notification
     */
    public static function notifyServicePosted($service): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::insertForAdmin($admin, 'service_posted', [
                'title' => 'New Service Posted',
                'message' => 'A new service has been posted.',
                'related_id' => $service->id,
                'related_type' => 'Service',
            ]);
        }
    }

    /**
     * Create a new event/announcement posted notification
     */
    public static function notifyEventPosted($event): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::insertForAdmin($admin, 'event_posted', [
                'title' => 'New Event/Announcement Posted',
                'message' => 'A new ' . ($event->type === 'announcement' ? 'announcement' : 'event') . ' has been posted.',
                'related_id' => $event->id,
                'related_type' => 'Event',
            ]);
        }
    }
}
