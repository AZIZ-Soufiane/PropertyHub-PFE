<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\Property;
use App\Models\User;
use App\Services\Admin\AdminPropertyService;

class AdminPropertyServiceTest extends TestCase
{
    protected AdminPropertyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminPropertyService();
    }

    public function test_get_all_properties()
    {
        Property::factory()->count(5)->create();

        $result = $this->service->getAllProperties(15);

        $this->assertCount(5, $result->items());
    }

    public function test_get_properties_by_status()
    {
        Property::factory()->count(3)->create(['status' => 'active']);
        Property::factory()->count(2)->create(['status' => 'sold']);

        $result = $this->service->getPropertiesByStatus('active');

        $this->assertCount(3, $result->items());
    }

    public function test_create_property()
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $property = $this->service->createProperty([
            'price' => 500000,
            'location' => 'New York',
            'status' => 'active',
            'agent_id' => $agent->id,
        ]);

        $this->assertEquals('New York', $property->location);
        $this->assertEquals(500000, $property->price);
        $this->assertEquals($agent->id, $property->agent_id);
    }

    public function test_create_property_throws_exception_for_non_agent()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Selected user is not an agent.");

        $this->service->createProperty([
            'price' => 500000,
            'location' => 'New York',
            'agent_id' => $buyer->id,
        ]);
    }

    public function test_update_property()
    {
        $property = Property::factory()->create();

        $updated = $this->service->updateProperty($property->id, [
            'price' => 600000,
            'location' => 'Los Angeles',
        ]);

        $this->assertEquals('Los Angeles', $updated->location);
        $this->assertEquals(600000, $updated->price);
    }

    public function test_delete_property()
    {
        $property = Property::factory()->create();

        $this->service->deleteProperty($property->id);

        $this->assertNull(Property::find($property->id));
    }

    public function test_search_by_location()
    {
        Property::factory()->create(['location' => 'New York']);
        Property::factory()->create(['location' => 'Los Angeles']);

        $result = $this->service->searchByLocation('New York');

        $this->assertCount(1, $result->items());
    }

    public function test_filter_by_price_range()
    {
        Property::factory()->create(['price' => 100000]);
        Property::factory()->create(['price' => 500000]);
        Property::factory()->create(['price' => 1000000]);

        $result = $this->service->filterByPriceRange(200000, 700000);

        $this->assertCount(1, $result->items());
    }

    public function test_get_properties_by_agent()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        Property::factory()->count(3)->create(['agent_id' => $agent->id]);

        $result = $this->service->getPropertiesByAgent($agent->id);

        $this->assertCount(3, $result->items());
    }

    public function test_get_property_statistics()
    {
        Property::factory()->count(5)->create(['status' => 'active', 'price' => 500000]);
        Property::factory()->count(2)->create(['status' => 'sold', 'price' => 600000]);

        $stats = $this->service->getPropertyStatistics();

        $this->assertEquals(7, $stats['total']);
        $this->assertEquals(5, $stats['active']);
        $this->assertEquals(2, $stats['sold']);
    }

    public function test_get_property_details()
    {
        $property = Property::factory()->create();

        $result = $this->service->getPropertyDetails($property->id);

        $this->assertEquals($property->id, $result->id);
    }

    public function test_bulk_update_status()
    {
        $properties = Property::factory()->count(3)->create(['status' => 'pending']);

        $updated = $this->service->bulkUpdateStatus(
            $properties->pluck('id')->toArray(),
            'active'
        );

        $this->assertEquals(3, $updated);
        $this->assertEquals(0, Property::where('status', 'pending')->count());
        $this->assertEquals(3, Property::where('status', 'active')->count());
    }

    public function test_update_property_with_new_agent()
    {
        $oldAgent = User::factory()->create(['role' => 'agent']);
        $newAgent = User::factory()->create(['role' => 'agent']);
        $property = Property::factory()->create(['agent_id' => $oldAgent->id]);

        $updated = $this->service->updateProperty($property->id, [
            'agent_id' => $newAgent->id,
        ]);

        $this->assertEquals($newAgent->id, $updated->agent_id);
    }
}
