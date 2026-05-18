<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Information_customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_customer',
        'phone_customer',
        'name_account_bank_customer',
        'number_account_bank_customer',
        'address_customer',
        'number_items',
        'picture_id',
        'is_sent',
    ];
    public function picture(): BelongsTo
    {
        return $this->belongsTo(Picture::class);
    }
}
