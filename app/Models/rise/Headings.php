<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Headings extends Model
{
    protected $table = 'table_rise_headings';
    protected $guarded = [];

    // Parent relationship
    public function parent()
    {
        return $this->belongsTo(Headings::class, 'heading_id');
    }

    // Children relationship
    public function children()
    {
        return $this->hasMany(Headings::class, 'heading_id', 'id');
    }

    /**
     * Slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->name) {
                if (!$model->slug || $model->getOriginal('name') !== $model->name) {
                    $model->slug = static::generateUniqueSlug($model->name, $model->id);
                }
            }
        });
    }

    public static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slugBase = Str::slug($name);
        $slug = $slugBase;
        $count = 0;

        while (static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()) {
            $count++;
            $slug = $slugBase . '-' . $count;
        }

        return $slug;
    }
}
