<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the member profile associated with the user.
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    /**
     * Get the givings approved by this admin.
     */
    public function givingsApproved()
    {
        return $this->hasMany(Giving::class, 'approved_by');
    }

    /**
     * Get the service registrations approved by this admin.
     */
    public function serviceRegistrationsApproved()
    {
        return $this->hasMany(ServiceRegistration::class, 'approved_by');
    }

    /**
     * Get the events created by this admin.
     */
    public function eventsCreated()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Get the group approvals given by this admin.
     */
    public function groupApprovalsGiven()
    {
        return \DB::table('group_member')
            ->where('approved_by', $this->id)
            ->where('status', 'approved');
    }

    /**
     * Get the profile image URL.
     */
    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return null;
        }

        // Check if it's a Supabase path (stored as 'admins/filename.ext')
        if (strpos($this->profile_image, 'admins/') === 0) {
            $supabaseUrl = env('SUPABASE_PUBLIC_URL');
            $bucket = env('SUPABASE_BUCKET', 'profiles');
            
            if ($supabaseUrl && $bucket) {
                return "{$supabaseUrl}/{$bucket}/{$this->profile_image}";
            }
            
            // If Supabase config is missing, fall back to local storage
            return asset('storage/' . $this->profile_image);
        }

        // Otherwise, it's a local storage path
        return asset('storage/' . $this->profile_image);
    }
    
    /**
     * Get the user's initials for avatar display.
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', trim($this->name));
        
        if (count($words) >= 2) {
            // First letter of first name and first letter of last name
            return strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
        }
        
        // Just first letter of name
        return strtoupper(substr($this->name, 0, 1));
    }
}
