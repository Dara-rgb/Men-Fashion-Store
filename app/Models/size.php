<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class size extends Model
{
    use HasFactory;
    protected $fillable = [
        'text_size',
    ];

    
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }
}
