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
    protected $casts = [
        'date_of_birth' => 'date',
        'date_joined' => 'date',
        'deleted_at' => 'datetime',
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

    // Helper method to safely format dates
    public function getFormattedDateJoinedAttribute()
    {
        try {
            if (!$this->date_joined) {
                return $this->created_at ? $this->created_at->format('M d, Y') : 'N/A';
            }
            
            if (is_string($this->date_joined)) {
                return \Carbon\Carbon::parse($this->date_joined)->format('M d, Y');
            }
            
            return $this->date_joined->format('M d, Y');
        } catch (\Exception $e) {
            return $this->created_at ? $this->created_at->format('M d, Y') : 'N/A';
        }
    }

    // Helper method to safely calculate age
    public function getAgeAttribute()
    {
        try {
            if (!$this->date_of_birth) {
                return null;
            }
            
            if (is_string($this->date_of_birth)) {
                return now()->diffInYears(\Carbon\Carbon::parse($this->date_of_birth));
            }
            
            return now()->diffInYears($this->date_of_birth);
        } catch (\Exception $e) {
            return null;
        }
    }

    // Image URL accessor methods
    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return $this->getDefaultProfileImageUrl();
        }

        try {
            // For now, always use local storage since we're storing locally
            // Check if it's a Supabase path (starts with 'members/')
            if (str_starts_with($this->profile_image, 'members/')) {
                // Use local storage URL for now
                return asset('storage/' . $this->profile_image);
                
                /* Uncomment when Supabase is working properly
                // Get Supabase public URL
                $supabaseUrl = config('filesystems.disks.supabase.url');
                $bucket = config('filesystems.disks.supabase.bucket');
                
                if ($supabaseUrl && $bucket) {
                    return $supabaseUrl . '/object/public/' . $bucket . '/' . $this->profile_image;
                }
                */
            }
            
            // Fall back to local storage URL
            return asset('storage/' . $this->profile_image);
            
        } catch (\Exception $e) {
            \Log::error('Error generating profile image URL', [
                'member_id' => $this->id,
                'profile_image' => $this->profile_image,
                'error' => $e->getMessage()
            ]);
            
            return $this->getDefaultProfileImageUrl();
        }
    }

    public function getDefaultProfileImageUrl()
    {
        // Generate a default avatar based on initials
        $initials = $this->full_name ? substr($this->full_name, 0, 1) : '?';
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=3B82F6&color=ffffff&size=200";
    }

    public function hasProfileImage()
    {
        return !empty($this->profile_image);
    }
}

