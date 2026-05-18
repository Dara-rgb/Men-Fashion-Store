<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'caption',
        'image',
        'price',
        'brand',
        'category_clothe_id',
        'category_fabric_id',
        'view',
    ];

    
    public function category_clothe(): BelongsTo
    {
        return $this->belongsTo(Category_clothe::class);
    }
    public function category_fabric(): BelongsTo
    {
        return $this->belongsTo(Category_fabric::class);
    }
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }

}
