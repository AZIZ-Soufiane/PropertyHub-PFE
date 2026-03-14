<?php

namespace Tests\Unit\Services\Public;

use Tests\TestCase;
use App\Models\Property;
use App\Models\User;
use App\Models\Gallery;
use App\Services\Public\PropertyService;

class PropertyServiceTest extends TestCase
{
    protected PropertyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PropertyService();
    }

    public function test_get_all_active_properties()
    {
        Property::factory()->count(5)->create(['status' => 'active']);
        Property::factory()->count(2)->create(['status' => 'sold']);

        $result = $this->service->getAllActiveProperties(15);

        $this->assertCount(5, $result->items());
    }

    public function test_get_property_details()
    {
        $property = Property::factory()->create();

        $result = $this->service->getPropertyDetails($property->id);

        $this->assertEquals($property->id, $result->id);
    }

    public function test_get_property_details_throws_exception_for_invalid_id()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->service->getPropertyDetails(999);
    }

    public function test_search_properties_by_location()
    {
        Property::factory()->create(['location' => 'New York', 'status' => 'active']);
        Property::factory()->create(['location' => 'Los Angeles', 'status' => 'active']);

        $result = $this->service->searchProperties('New York');

        $this->assertCount(1, $result->items());
    }

    public function test_search_properties_by_price_range()
    {
        Property::factory()->create(['price' => 100000, 'status' => 'active']);
        Property::factory()->create(['price' => 500000, 'status' => 'active']);

        $result = $this->service->searchProperties(null, 100000, 300000);

        $this->assertCount(1, $result->items());
    }

    public function test_get_properties_by_agent()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        Property::factory()->count(3)->create(['agent_id' => $agent->id, 'status' => 'active']);

        $result = $this->service->getPropertiesByAgent($agent->id);

        $this->assertCount(3, $result->items());
    }

    public function test_add_to_favorites()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $property = Property::factory()->create();

        $this->service->addToFavorites($buyer->id, $property->id);

        $this->assertTrue($this->service->isFavorited($buyer->id, $property->id));
    }

    public function test_remove_from_favorites()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $property = Property::factory()->create();

        $this->service->addToFavorites($buyer->id, $property->id);
        $this->service->removeFromFavorites($buyer->id, $property->id);

        $this->assertFalse($this->service->isFavorited($buyer->id, $property->id));
    }

    public function test_is_favorited()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $property = Property::factory()->create();

        $this->assertFalse($this->service->isFavorited($buyer->id, $property->id));

        $this->service->addToFavorites($buyer->id, $property->id);

        $this->assertTrue($this->service->isFavorited($buyer->id, $property->id));
    }

    public function test_get_buyer_favorites()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $properties = Property::factory()->count(3)->create();

        foreach ($properties as $property) {
            $this->service->addToFavorites($buyer->id, $property->id);
        }

        $favorites = $this->service->getBuyerFavorites($buyer->id);

        $this->assertCount(3, $favorites->items());
    }

    public function test_get_properties_by_status()
    {
        Property::factory()->count(4)->create(['status' => 'pending']);
        Property::factory()->count(2)->create(['status' => 'active']);

        $result = $this->service->getPropertiesByStatus('pending');

        $this->assertCount(4, $result->items());
    }

    public function test_add_duplicate_favorite_does_not_duplicate()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $property = Property::factory()->create();

        $this->service->addToFavorites($buyer->id, $property->id);
        $this->service->addToFavorites($buyer->id, $property->id);

        $favorites = $this->service->getBuyerFavorites($buyer->id);

        $this->assertCount(1, $favorites->items());
    }
}
