<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    // Model properties and methods
    protected $table = 'admins';
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'otp',
        'otp_expires_at'
    ];
}
