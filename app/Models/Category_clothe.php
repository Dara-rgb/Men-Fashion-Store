<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category_clothe extends Model
{
    use HasFactory;
    protected $fillable = [
        'text_clothes',
        'clothe_id',
    ];

    public function clothe(): BelongsTo
    {
        return $this->belongsTo(Clothe::class);
    }
    
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
