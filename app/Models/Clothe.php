<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Clothe extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
    ];

    public function category_clothes(): HasMany
    {
        return $this->hasMany(Category_clothe::class);
    }
}
