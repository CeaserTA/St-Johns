<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id',
        'member_id',
        'guest_first_name',
        'guest_last_name',
        'guest_email',
        'guest_phone',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // Notify admins of new event registration
            Notification::notifyEventRegistration($model);
        });
    }

    /**
     * Relationships
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Accessors
     */
    public function getFullNameAttribute()
    {
        // If registered as a member, use member's name
        if ($this->member_id && $this->member) {
            return $this->member->full_name;
        }
        // Otherwise use guest name
        return trim($this->guest_first_name . ' ' . $this->guest_last_name);
    }

    public function getFirstNameAttribute()
    {
        return $this->member_id && $this->member ? $this->member->first_name : $this->guest_first_name;
    }

    public function getLastNameAttribute()
    {
        return $this->member_id && $this->member ? $this->member->last_name : $this->guest_last_name;
    }

    public function getEmailAttribute()
    {
        return $this->member_id && $this->member ? $this->member->email : $this->guest_email;
    }

    public function getPhoneAttribute()
    {
        return $this->member_id && $this->member ? $this->member->phone : $this->guest_phone;
    }

    /**
     * Scopes
     */
    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }
}
