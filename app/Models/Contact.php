<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_contact',
        'phone_contact',
        'image_contact',
        'link_payment',
        'telegram_id',
    ];

    
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }
}
