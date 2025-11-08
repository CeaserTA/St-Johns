<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRegistration extends Model
{
    protected $table = 'service_registrations';

    protected $fillable = [
        'full_name',
        'email',
        'address',
        'phone_number',
        'service',
    ];
}

