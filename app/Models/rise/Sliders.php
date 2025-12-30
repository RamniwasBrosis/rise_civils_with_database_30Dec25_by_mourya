<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table = 'table_sliders';
    
    protected $fillable = [ 'image' , 'status', 'image_url', 'forYoutube'];
}
