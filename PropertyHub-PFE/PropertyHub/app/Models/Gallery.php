<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_urls',
    ];

    protected $casts = [
        'image_urls' => 'array',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
