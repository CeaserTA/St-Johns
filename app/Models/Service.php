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
    ];

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
}
