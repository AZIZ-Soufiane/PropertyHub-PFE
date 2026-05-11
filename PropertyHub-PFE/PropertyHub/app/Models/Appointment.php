<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_time',
        'status',
        'buyer_id',
        'agent_id',
        'calendar_id',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
