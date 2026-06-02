<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $with = ['statusRelation'];

    protected $fillable = [
        'title',
        'type',
        'price',
        'location',
        'address',
        'city',
        'country',
        'area',
        'bedrooms',
        'bathrooms',
        'description',
        'features',
        'status_id',
        'agent_id',
    ];

    public function statusRelation()
    {
        return $this->belongsTo(PropertyStatus::class, 'status_id');
    }

    public function getStatusAttribute()
    {
        return $this->statusRelation?->name;
    }

    public function setStatusAttribute($value)
    {
        if ($value) {
            $status = PropertyStatus::firstOrCreate(['name' => $value]);
            $this->attributes['status_id'] = $status->id;
        }
    }

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

    public function images()
    {
        return $this->hasMany(Gallery::class);
    }

    public function getImageUrlAttribute()
    {
        $firstImage = $this->images->first();
        if ($firstImage && is_array($firstImage->image_urls) && count($firstImage->image_urls) > 0) {
            return $firstImage->image_urls[0];
        }
        return 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800';
    }

    public function getAllImageUrlsAttribute()
    {
        $urls = [];
        foreach ($this->images as $gallery) {
            if (is_array($gallery->image_urls)) {
                $urls = array_merge($urls, $gallery->image_urls);
            }
        }
        return !empty($urls) ? $urls : ['https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800'];
    }
}
