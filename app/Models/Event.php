<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    // Type constants
    const TYPE_EVENT = 'event';
    const TYPE_ANNOUNCEMENT = 'announcement';

    // Category constants
    const CATEGORY_GENERAL = 'General';
    const CATEGORY_YOUTH = 'Youth';
    const CATEGORY_PRAYER = 'Prayer';
    const CATEGORY_SERVICE = 'Service';
    const CATEGORY_WORSHIP = 'Worship';
    const CATEGORY_FELLOWSHIP = 'Fellowship';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // Notify admins of new event/announcement posted
            Notification::notifyEventPosted($model);
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'type',
        'category',
        'date',
        'time',
        'location',
        'starts_at',
        'ends_at',
        'expires_at',
        'image',
        'is_pinned',
        'is_active',
        'view_count',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'view_count' => 'integer',
    ];

    protected $attributes = [
        'type' => self::TYPE_EVENT,
        'is_pinned' => false,
        'is_active' => true,
        'view_count' => 0,
    ];

    // Boot method for auto-generating slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = $event->generateUniqueSlug($event->title);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('title') && empty($event->slug)) {
                $event->slug = $event->generateUniqueSlug($event->title);
            }
        });
    }

    /**
     * Generate a unique slug from title
     */
    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Query Scopes
     */
    public function scopeEvents($query)
    {
        return $query->where('type', self::TYPE_EVENT);
    }

    public function scopeAnnouncements($query)
    {
        return $query->where('type', self::TYPE_ANNOUNCEMENT);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
                     ->where('expires_at', '<=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where(function ($q) {
            $q->where('starts_at', '>', now())
              ->orWhere('date', '>', now()->toDateString());
        });
    }

    public function scopePast($query)
    {
        return $query->where(function ($q) {
            $q->where('starts_at', '<', now())
              ->orWhere('date', '<', now()->toDateString());
        });
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePublished($query)
    {
        return $query->active()
                     ->notExpired()
                     ->where(function ($q) {
                         $q->whereNull('starts_at')
                           ->orWhere('starts_at', '<=', now());
                     });
    }

    /**
     * Accessors & Mutators
     */
    public function getIsEventAttribute()
    {
        return $this->type === self::TYPE_EVENT;
    }

    public function getIsAnnouncementAttribute()
    {
        return $this->type === self::TYPE_ANNOUNCEMENT;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsUpcomingAttribute()
    {
        if ($this->starts_at) {
            return $this->starts_at->isFuture();
        }
        if ($this->date) {
            return $this->date->isFuture();
        }
        return false;
    }

    public function getIsPastAttribute()
    {
        if ($this->starts_at) {
            return $this->starts_at->isPast();
        }
        if ($this->date) {
            return $this->date->isPast();
        }
        return false;
    }

    public function getFormattedDateAttribute()
    {
        if ($this->starts_at) {
            return $this->starts_at->format('M d, Y');
        }
        if ($this->date) {
            return $this->date->format('M d, Y');
        }
        return null;
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->starts_at) {
            return $this->starts_at->format('g:i A');
        }
        if ($this->time) {
            return Carbon::parse($this->time)->format('g:i A');
        }
        return null;
    }

    public function getFormattedDateTimeAttribute()
    {
        if ($this->starts_at) {
            return $this->starts_at->format('M d, Y \a\t g:i A');
        }
        if ($this->date && $this->time) {
            return $this->date->format('M d, Y') . ' at ' . Carbon::parse($this->time)->format('g:i A');
        }
        if ($this->date) {
            return $this->date->format('M d, Y');
        }
        return null;
    }

    public function getExcerptAttribute()
    {
        if ($this->description) {
            return Str::limit($this->description, 150);
        }
        if ($this->content) {
            return Str::limit(strip_tags($this->content), 150);
        }
        return null;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If it's a full URL, return as is
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }
            // Check if it's a Supabase path and construct the full URL
            $supabasePublicUrl = config('filesystems.disks.supabase.url');
            $bucket = config('filesystems.disks.supabase.bucket');
            if ($supabasePublicUrl && $bucket) {
                return $supabasePublicUrl . '/' . $bucket . '/' . $this->image;
            }
            // Otherwise, assume it's in local storage
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Helper Methods
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function pin()
    {
        $this->update(['is_pinned' => true]);
    }

    public function unpin()
    {
        $this->update(['is_pinned' => false]);
    }

    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    public function setExpiration($date)
    {
        $this->update(['expires_at' => $date]);
    }

    public function removeExpiration()
    {
        $this->update(['expires_at' => null]);
    }

    /**
     * Static helper methods
     */
    public static function getTypes()
    {
        return [
            self::TYPE_EVENT => 'Event',
            self::TYPE_ANNOUNCEMENT => 'Announcement',
        ];
    }

    public static function getCategories()
    {
        return [
            self::CATEGORY_GENERAL,
            self::CATEGORY_YOUTH,
            self::CATEGORY_PRAYER,
            self::CATEGORY_SERVICE,
            self::CATEGORY_WORSHIP,
            self::CATEGORY_FELLOWSHIP,
        ];
    }
}
