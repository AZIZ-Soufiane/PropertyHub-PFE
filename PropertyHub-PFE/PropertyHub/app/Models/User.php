<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'license_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function agentProperties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function calendar()
    {
        return $this->hasOne(Calendar::class, 'agent_id');
    }

    public function appointmentsAsBuyer()
    {
        return $this->hasMany(Appointment::class, 'buyer_id');
    }

    public function appointmentsAsAgent()
    {
        return $this->hasMany(Appointment::class, 'agent_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Property::class, 'property_user', 'user_id', 'property_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'admin_id');
    }
}
