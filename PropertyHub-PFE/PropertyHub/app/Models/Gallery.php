<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'url',
    ];

    protected $casts = [
        'url' => 'array',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
