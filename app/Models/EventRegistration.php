<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id',
        'event_name',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];
}
