<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    use SoftDeletes, HasFactory;

    // Updated fillable to match the improved migration columns
    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'phone',
        'email',
        'address',
        'date_joined',
        'cell',
        'profile_image',
    ];

    // Cast date fields to Carbon instances
    protected $dates = [
        'date_of_birth',
        'date_joined',
        'deleted_at',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_member')->withTimestamps();
    }

    public function givings(): HasMany
    {
        return $this->hasMany(Giving::class);
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(\App\Models\EventRegistration::class);
    }

    public function serviceRegistrations(): HasMany
    {
        return $this->hasMany(\App\Models\ServiceRegistration::class);
    }

    // Giving-related methods
    public function getTotalGivingAttribute(): float
    {
        return $this->givings()->completed()->sum('amount');
    }

    public function getTithesThisYearAttribute(): float
    {
        return $this->givings()
            ->completed()
            ->byType('tithe')
            ->thisYear()
            ->sum('amount');
    }

    public function getOfferingsThisYearAttribute(): float
    {
        return $this->givings()
            ->completed()
            ->byType('offering')
            ->thisYear()
            ->sum('amount');
    }

    public function getDonationsThisYearAttribute(): float
    {
        return $this->givings()
            ->completed()
            ->whereIn('giving_type', ['donation', 'special_offering'])
            ->thisYear()
            ->sum('amount');
    }

    // Normalize gender and marital status values
    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = is_string($value) ? strtolower($value) : $value;
    }

    public function setMaritalStatusAttribute($value)
    {
        $this->attributes['marital_status'] = is_string($value) ? strtolower($value) : $value;
    }
}

