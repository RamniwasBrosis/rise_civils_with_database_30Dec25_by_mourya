<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypesOf extends Model
{
    protected $table = 'table_types';
    
    protected $fillable = [
            'type', 'title', 'description', 'page_content', 'status', 'order_no', 'slug'
        ];
        
        
    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($type) {
            if (empty($type->slug)) {
                $type->slug = Str::slug($type->type);
            }
        });
    }
}
