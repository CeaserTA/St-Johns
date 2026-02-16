<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRegistration extends Model
{
    protected $table = 'service_registrations';

    protected $fillable = [
        'service_id',
        'member_id',
        'guest_full_name',
        'guest_email',
        'guest_address',
        'guest_phone',
    ];

    /**
     * Get the service that this registration belongs to
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the member that this registration belongs to (if any)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Check if this is a guest registration
     */
    public function isGuest()
    {
        return is_null($this->member_id);
    }

    /**
     * Get the registrant's name (member or guest)
     */
    public function getRegistrantNameAttribute()
    {
        return $this->member ? $this->member->full_name : $this->guest_full_name;
    }

    /**
     * Get the registrant's email (member or guest)
     */
    public function getRegistrantEmailAttribute()
    {
        return $this->member ? $this->member->email : $this->guest_email;
    }

    /**
     * Get the registrant's phone (member or guest)
     */
    public function getRegistrantPhoneAttribute()
    {
        return $this->member ? $this->member->phone : $this->guest_phone;
    }
}

