<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    // Keep the app-level attribute names (first_name / last_name) so views and controllers
    // can use those, but map them to the actual DB columns (firstname / lastname)
    protected $fillable = ['first_name', 'last_name', 'gender', 'phone', 'email', 'address'];

    // Accessors & mutators to map between 'first_name' <-> DB column 'firstname'
    public function setFirstNameAttribute($value)
    {
        $this->attributes['firstname'] = $value;
    }

    public function getFirstNameAttribute()
    {
        return $this->attributes['firstname'] ?? null;
    }

    // Map 'last_name' <-> 'lastname'
    public function setLastNameAttribute($value)
    {
        $this->attributes['lastname'] = $value;
    }

    public function getLastNameAttribute()
    {
        return $this->attributes['lastname'] ?? null;
    }

    // Normalize gender to lowercase so it matches the DB enum (which uses 'male'/'female')
    public function setGenderAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['gender'] = strtolower($value);
        } else {
            $this->attributes['gender'] = $value;
        }
    }
}
