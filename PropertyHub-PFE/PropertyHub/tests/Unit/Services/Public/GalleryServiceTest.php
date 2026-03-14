<?php

namespace Tests\Unit\Services\Public;

use Tests\TestCase;
use App\Models\Gallery;
use App\Models\Property;
use App\Services\Public\GalleryService;

class GalleryServiceTest extends TestCase
{
    protected GalleryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GalleryService();
    }

    public function test_get_property_gallery()
    {
        $property = Property::factory()->create();
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['image1.jpg', 'image2.jpg'],
        ]);

        $images = $this->service->getPropertyGallery($property->id);

        $this->assertCount(2, $images);
    }

    public function test_get_gallery_details()
    {
        $gallery = Gallery::factory()->create();

        $result = $this->service->getGalleryDetails($gallery->id);

        $this->assertEquals($gallery->id, $result->id);
    }

    public function test_count_property_images()
    {
        $property = Property::factory()->create();
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['image1.jpg', 'image2.jpg'],
        ]);
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['image3.jpg'],
        ]);

        $count = $this->service->countPropertyImages($property->id);

        $this->assertEquals(3, $count);
    }

    public function test_has_images()
    {
        $property = Property::factory()->create();

        $this->assertFalse($this->service->hasImages($property->id));

        Gallery::factory()->create(['property_id' => $property->id]);

        $this->assertTrue($this->service->hasImages($property->id));
    }

    public function test_get_property_thumbnail()
    {
        $property = Property::factory()->create();
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['thumbnail.jpg', 'image2.jpg'],
        ]);

        $thumbnail = $this->service->getPropertyThumbnail($property->id);

        $this->assertEquals('thumbnail.jpg', $thumbnail);
    }

    public function test_get_property_thumbnail_returns_null_for_no_images()
    {
        $property = Property::factory()->create();

        $thumbnail = $this->service->getPropertyThumbnail($property->id);

        $this->assertNull($thumbnail);
    }

    public function test_get_property_gallery_multiple_galleries()
    {
        $property = Property::factory()->create();
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['image1.jpg', 'image2.jpg'],
        ]);
        Gallery::factory()->create([
            'property_id' => $property->id,
            'image_urls' => ['image3.jpg'],
        ]);

        $images = $this->service->getPropertyGallery($property->id);

        $this->assertCount(3, $images);
    }
}
