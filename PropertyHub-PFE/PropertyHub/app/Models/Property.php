<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'price',
        'location',
        'status',
        'agent_id',
    ];

    // Relationships
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function buyers()
    {
        return $this->belongsToMany(User::class, 'property_user', 'property_id', 'user_id');
    }
}
