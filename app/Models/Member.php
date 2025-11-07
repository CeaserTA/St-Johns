<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'phone', 'email', 'address'];
}
