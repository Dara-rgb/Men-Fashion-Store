<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;


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


    // 🔥 ចាប់យកការអាប់ឡូតរូបភាព Contact (QR Code ឬ រូបភាពផ្សេងៗ)
    public function setImageContactAttribute($value)
    {
        if (request()->hasFile('image_contact') && is_object($value)) {
            $path = Storage::disk('supabase')->putFile('contacts', $value);
            $this->attributes['image_contact'] = Storage::disk('supabase')->url($path);
        } else {
            $this->attributes['image_contact'] = $value;
        }
    }
    
    public function pictures(): HasMany
    {
        return $this->hasMany(Picture::class);
    }
}
