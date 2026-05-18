<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_admin',
        'picture_admin',
        'phone_number_admin',
        'cover_admin',
        'address_admin',
        'link_map_admin',
    ];

    // 🔥 ចាប់យកការអាប់ឡូតរូបភាព Admin
    public function setPictureAdminAttribute($value)
    {
        if (request()->hasFile('picture_admin') && is_object($value)) {
            $path = Storage::disk('supabase')->putFile('admin/profiles', $value);
            $this->attributes['picture_admin'] = Storage::disk('supabase')->url($path);
        } else {
            $this->attributes['picture_admin'] = $value;
        }
    }

    // 🔥 ចាប់យកការអាប់ឡូតរូប Cover Admin
    public function setCoverAdminAttribute($value)
    {
        if (request()->hasFile('cover_admin') && is_object($value)) {
            $path = Storage::disk('supabase')->putFile('admin/covers', $value);
            $this->attributes['cover_admin'] = Storage::disk('supabase')->url($path);
        } else {
            $this->attributes['cover_admin'] = $value;
        }
    }
}
