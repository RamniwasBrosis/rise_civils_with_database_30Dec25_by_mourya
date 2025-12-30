<?php

namespace App\Models\rise;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\rise\TypesOf;
use App\Models\rise\Categories;

class Subjects extends Model
{
    protected $table = "table_rise_subjects";
    
    protected $fillable = ['name', 'type_id', 'category_id', 'status'];
    
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypesOf::class, 'type_id');
    }
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    
}
