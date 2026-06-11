<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $fillable = [
        'property_id',
        'amount',
        'type',
        'agent_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
