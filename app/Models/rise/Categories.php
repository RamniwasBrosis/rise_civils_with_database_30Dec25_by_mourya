<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\rise\TypesOf;
use App\Models\rise\Posts;
use App\Models\rise\Chapter;
use Illuminate\Support\Str;

class Categories extends Model
{
    protected $table = 'table_rise_categories';
    
    protected $fillable = ['name', 'type_id', 'status', 'category_id', 'order_no', 'cat_image', 'slug', 'short_description', 'isFeature'];
    
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypesOf::class, 'type_id');
    }
    
    public function children()
    {
        return $this->hasMany(Categories::class, 'category_id', 'id')
                    ->where('status', 1)
                    ->with('children');;
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
    
    
    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($category) {
    
            // Only generate slug if it's empty
            if (empty($category->slug)) {
                $originalSlug = Str::slug($category->name); // base slug
                $slug = $originalSlug;
                $counter = 1;
    
                // Check if the slug already exists (ignore current record on update)
                while (Categories::where('slug', $slug)
                        ->where('id', '!=', $category->id)
                        ->exists()) {
                    $slug = $originalSlug . '-' . $counter; // append counter
                    $counter++;
                }
    
                $category->slug = $slug; // assign unique slug
            }
        });
    }


    
    // public function parent()
    // {
    //     return $this->belongsTo(Categories::class, 'category_id');
    // }
    
    
    public function parent()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Posts::class, 'category_id');
    }
    
    // public function posts()
    // {
    //     return $this->hasMany(Posts::class, 'category_id')
    //                 ->where('showOnFront', 1);
    // }
    
    // public function grandParent()
    // {
    //     return $this->belongsTo(Categories::class, 'category_id')
    //                 ->with('parent');
    // }
    
    // bhavesh
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'category_id')->with('parent');
    }
    
    
    
}
