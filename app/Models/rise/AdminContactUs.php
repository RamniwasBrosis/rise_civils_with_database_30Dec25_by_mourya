<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;

class AdminContactUs extends Model
{
    protected $table = 'admin_contact_us';

    protected $fillable = [
        'title',
        'description',
        'address',
        'phone',
        'email',
        'status',
    ];
}
