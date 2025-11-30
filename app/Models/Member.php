<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Make fillable match the members migration columns
    protected $fillable = [
        'fullname',
        'dateOfBirth',
        'gender',
        'maritalStatus',
        'phone',
        'email',
        'address',
        'dateJoined',
        'cell',
        'profileImage',
    ];

    // Cast date fields to Carbon instances
    protected $dates = [
        'dateOfBirth',
        'dateJoined',
    ];

    // Normalize gender and marital status values
    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = is_string($value) ? strtolower($value) : $value;
    }

    public function setMaritalStatusAttribute($value)
    {
        $this->attributes['maritalStatus'] = is_string($value) ? strtolower($value) : $value;
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_member')->withTimestamps();
    }


}

