<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'schedule',
        'fee',
        'is_free',
        'currency',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'is_free' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // Notify admins of new service posted
            Notification::notifyServicePosted($model);
        });
    }

    /**
     * Get all registrations for this service
     */
    public function registrations()
    {
        return $this->hasMany(ServiceRegistration::class);
    }

    /**
     * Get the count of registrations for this service
     */
    public function getRegistrationsCountAttribute()
    {
        return $this->registrations()->count();
    }

    /**
     * Check if the service is free
     */
    public function isFree(): bool
    {
        return $this->is_free || $this->fee <= 0;
    }

    /**
     * Get formatted fee with currency
     */
    public function getFormattedFeeAttribute(): string
    {
        if ($this->isFree()) {
            return 'Free';
        }
        return $this->currency . ' ' . number_format($this->fee, 0);
    }
}
