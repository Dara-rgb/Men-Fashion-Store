<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Picture extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_picture',
        'post_id',
        'contact_id',
        'size_id',
    ];
    protected $casts = [
        'image_picture' => 'array',
    ];
    
    
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(size::class);
    }
    public function information_customers(): HasMany
    {
        return $this->hasMany(Information_customer::class);
    }
}
