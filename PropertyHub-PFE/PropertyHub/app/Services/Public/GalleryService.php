<?php

namespace App\Services\Public;

use App\Models\Gallery;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class GalleryService
{
    /**
     * Get all images for a property.
     * 
     * @param int $propertyId
     * @return array
     */
    public function getPropertyGallery(int $propertyId): array
    {
        $property = Property::findOrFail($propertyId);
        $galleries = Gallery::where('property_id', $propertyId)->get();

        $images = [];
        foreach ($galleries as $gallery) {
            if (is_array($gallery->image_urls)) {
                $images = array_merge($images, $gallery->image_urls);
            }
        }

        return $images;
    }

    /**
     * Get gallery item details.
     * 
     * @param int $galleryId
     * @return Gallery
     */
    public function getGalleryDetails(int $galleryId): Gallery
    {
        return Gallery::findOrFail($galleryId);
    }

    /**
     * Count images in property gallery.
     * 
     * @param int $propertyId
     * @return int
     */
    public function countPropertyImages(int $propertyId): int
    {
        $galleries = Gallery::where('property_id', $propertyId)->get();
        $count = 0;

        foreach ($galleries as $gallery) {
            if (is_array($gallery->image_urls)) {
                $count += count($gallery->image_urls);
            }
        }

        return $count;
    }

    /**
     * Check if property has images.
     * 
     * @param int $propertyId
     * @return bool
     */
    public function hasImages(int $propertyId): bool
    {
        return Gallery::where('property_id', $propertyId)->exists();
    }

    /**
     * Get first image of property (thumbnail).
     * 
     * @param int $propertyId
     * @return string|null
     */
    public function getPropertyThumbnail(int $propertyId): ?string
    {
        $gallery = Gallery::where('property_id', $propertyId)->first();

        if ($gallery && is_array($gallery->image_urls) && count($gallery->image_urls) > 0) {
            return $gallery->image_urls[0];
        }

        return null;
    }
}
