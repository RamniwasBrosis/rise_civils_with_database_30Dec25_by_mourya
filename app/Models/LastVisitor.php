<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastVisitor extends Model
{
    protected $table = 'last_visitors';
    
    protected $fillable = ['user_id', 'date', 'passenger_count'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
