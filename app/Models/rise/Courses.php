<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'courses';
    
    protected $fillable = ['title', 'thumbnail', 'link', 'description', 'isFeatured', 'showOnFront', 'price', 'status'];
}
