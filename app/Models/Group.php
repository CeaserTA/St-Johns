<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'meeting_day', 'location', 'is_active', 'sort_order',
        'icon', 'image_url', 'category',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member')
            ->withPivot('status', 'approved_by', 'approved_at')
            ->withTimestamps();
    }

    /**
     * Get only approved members
     */
    public function approvedMembers()
    {
        return $this->belongsToMany(Member::class, 'group_member')
            ->wherePivot('status', 'approved')
            ->withPivot('status', 'approved_by', 'approved_at')
            ->withTimestamps();
    }

    /**
     * Get pending members
     */
    public function pendingMembers()
    {
        return $this->belongsToMany(Member::class, 'group_member')
            ->wherePivot('status', 'pending')
            ->withPivot('status', 'approved_by', 'approved_at')
            ->withTimestamps();
    }

    /**
     * Get the image URL attribute (accessor for displaying images)
     */
    public function getImageUrlAttribute($value)
    {
        // If there's a value in image_url column
        if ($value) {
            // If it's a full URL, return as is
            if (Str::startsWith($value, ['http://', 'https://'])) {
                return $value;
            }
            
            // If it starts with 'assets/', it's in public/assets directory
            if (Str::startsWith($value, 'assets/')) {
                return asset($value);
            }
            
            // Check if it's a Supabase path and construct the full URL
            $supabasePublicUrl = config('filesystems.disks.supabase.url');
            $bucket = config('filesystems.disks.supabase.bucket');
            if ($supabasePublicUrl && $bucket) {
                return $supabasePublicUrl . '/' . $bucket . '/' . $value;
            }
            
            // Otherwise, assume it's in local storage
            return asset('storage/' . $value);
        }
        return null;
    }
}
