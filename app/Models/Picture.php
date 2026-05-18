<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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
    
    public function setImagePictureAttribute($value)
    {
        // បើវាជា Array នៃ File រូបភាពជាច្រើន
        if (is_array($value)) {
            $urls = [];
            foreach ($value as $file) {
                if (is_object($file)) {
                    $path = Storage::disk('supabase')->putFile('gallery', $file);
                    $urls[] = Storage::disk('supabase')->url($path);
                } else {
                    $urls[] = $file; // បើជា URL ស្រាប់ ទុកដដែល
                }
            }
            $this->attributes['image_picture'] = json_encode($urls);
        } else {
            $this->attributes['image_picture'] = $value;
        }
    }
    
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
