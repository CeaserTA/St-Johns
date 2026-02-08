<?php

namespace App\Models;

/**
 * @deprecated This model is deprecated. Use Event model with type='announcement' instead.
 * 
 * The Announcement functionality has been merged into the Event model.
 * Use Event::announcements() scope to query announcements.
 * 
 * This class is kept for backward compatibility only.
 */
class Announcement extends Event
{
    protected $table = 'events';

    protected $attributes = [
        'type' => Event::TYPE_ANNOUNCEMENT,
        'is_pinned' => false,
        'is_active' => true,
        'view_count' => 0,
    ];

    /**
     * Boot method to automatically set type to announcement
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('announcement', function ($query) {
            $query->where('type', Event::TYPE_ANNOUNCEMENT);
        });
    }

    /**
     * Get the latest announcement
     */
    public static function latest()
    {
        return static::active()
                     ->notExpired()
                     ->orderBy('created_at', 'desc')
                     ->first();
    }
}
