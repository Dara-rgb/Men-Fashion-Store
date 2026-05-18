<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
