<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category_fabric extends Model
{
    use HasFactory;
    protected $fillable = [
        'text_fabrics',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

