<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chapter extends Model
{
    protected $guarded = [];
    
    public function category(){
         return $this->belongsTo(\App\Models\rise\Categories::class, 'category_id', 'id');
    }
    

    public function parent(){
        return $this->belongsTo(\App\Models\rise\Categories::class, 'category_id', 'id');
    }
    
    public function getParentCategoryAttribute()
    {
        return $this->category->parent;
    }
    
    public function getParentCategoryNameAttribute()
    {
        return $this->category && $this->category->parent
            ? $this->category->parent->name
            : null;
    }
    
    public function posts(){
        return $this->hasMany(\App\Models\rise\Posts::class, 'category_id', 'id');
    }
    
    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::saving(function ($category) {
    //         if (empty($category->slug)) {
    //             $category->slug = Str::slug($category->name);
    //         }
    //     });
    // }
    
    // protected static function boot()
    // {
    //     parent::boot();
    
    //     // Before saving: generate slug from name
    //     static::saving(function ($category) {
    //         if (empty($category->slug)) {
    //             $category->slug = Str::slug($category->name); // temporary slug
    //         }
    //     });
    
    //     // After create: append ID to slug
    //     static::created(function ($category) {
    //         // Append ID if not already in slug
    //         if (!Str::endsWith($category->slug, '-' . $category->id)) {
    //             $category->slug = $category->slug . '-' . $category->id;
    //             $category->saveQuietly(); // avoids infinite loop
    //         }
    //     });
    // }
    
    
    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($chapter) {
            // Generate slug if empty OR name has changed
            if (empty($chapter->slug) || $chapter->isDirty('name')) {
                $originalSlug = Str::slug($chapter->name); // base slug
                $slug = $originalSlug;
                $counter = 1;
    
                // Ensure the slug is unique in the 'chapters' table
                while (Chapter::where('slug', $slug)
                        ->where('id', '!=', $chapter->id)
                        ->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
    
                $chapter->slug = $slug; // assign unique slug
            }
        });
    }






    
}
