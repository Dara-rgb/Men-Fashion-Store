<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    // 🔥 ចាប់យកការអាប់ឡូតរូបភាពដើមរបស់ Post ទំនិញ
    public function setImageAttribute($value)
    {
        if (request()->hasFile('image') && is_object($value)) {
            $path = Storage::disk('supabase')->putFile('posts', $value);
            $this->attributes['image'] = Storage::disk('supabase')->url($path);
        } else {
            $this->attributes['image'] = $value;
        }
    }
    
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
