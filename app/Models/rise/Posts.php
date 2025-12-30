<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\rise\Categories;
use App\Models\rise\Chapter;
use Illuminate\Support\Str;

class Posts extends Model
{
    protected $table = 'table_posts';
    
    protected $fillable = ['name', 'description', 'content', 'image', 'pdf', 'status' ,'category_id','pass_protected', 'isFeature', 'showOnFront'];
    
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'category_id');
    }
    
    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::saving(function ($post) {
    //         if (empty($post->slug)) {
    //             $post->slug = Str::slug($post->name);
    //         }
    //     });
    // }
    
    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::saving(function ($post) {
    //         if (empty($post->slug)) {
    //             // generate slug from name
    //             $slug = Str::slug($post->name);
    
    //             // append ID if it exists (for updates)
    //             $idPart = $post->id ?? ''; // if new post, id is null
    
    //             // temporarily save slug without id if it's a new record
    //             $post->slug = $slug . ($idPart ? '-' . $idPart : '');
    //         }
    //     });
    
    //     // After create, update slug with the actual id for new records
    //     static::created(function ($post) {
    //         // If slug does not already contain the ID, append it
    //         if (!Str::endsWith($post->slug, '-' . $post->id)) {
    //             $post->slug = Str::slug($post->name) . '-' . $post->id;
    //             $post->saveQuietly(); // avoid infinite loop
    //         }
    //     });
    // }
    
    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($post) {
            if (empty($post->slug)) {
                // Generate initial slug
                $slug = Str::slug($post->name);
                $originalSlug = $slug;
                $count = 1;
    
                // Check for existing slugs in the same table
                while (Posts::where('slug', $slug)
                            ->where('id', '!=', $post->id) // ignore current post when updating
                            ->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
    
                $post->slug = $slug;
            }
        });
    }


    


    public function getFullUrl()
    {
        $chapter = $this->chapter; // posts.category_id = chapter.id
    
        if (!$chapter) {
            return url("study-posts/no-category/no-chapter/{$this->slug}");
        }
    
        // category = actual category of this chapter (e.g. world-history)
        $category = $chapter->category;
    
        // parent = optional parent category (like 'world'), but we don't use it for the URL
        // because your working route expects only 2 slugs after study-posts
        $parentCategory = $category?->parent;
    
        // Route expects: /study-posts/{categorySlug}/{parentSlug}/{slug}
        $categorySlug = $category?->slug ?? 'no-category';
        $chapterSlug  = $chapter?->slug ?? 'no-chapter';
        $postSlug     = $this->slug ?? 'no-post';
    
        return url("study-posts/{$categorySlug}/{$chapterSlug}/{$postSlug}");
    }




}
