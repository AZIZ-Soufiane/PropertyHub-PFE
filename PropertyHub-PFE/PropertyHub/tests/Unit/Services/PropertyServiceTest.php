<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Property;
use App\Models\User;
use App\Services\PropertyService;

class PropertyServiceTest extends TestCase
{
    protected PropertyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PropertyService();
    }

    /**
     * @group mvp
     */
    public function test_get_properties_public_view()
    {
        $property = Property::where('status', 'available')->first();
        if ($property) {
            $property->update(['status' => 'active']);
        }

        $result = $this->service->getProperties('active');

        $this->assertGreaterThanOrEqual(1, $result->total());
        foreach($result->items() as $item) {
            $this->assertEquals('active', $item->status);
        }
    }

    /**
     * @group mvp
     */
    public function test_get_all_properties_admin_view()
    {
        $result = $this->service->getProperties();

        $this->assertGreaterThanOrEqual(1, $result->total());
    }

    /**
     * @group mvp
     */
    public function test_search_properties_public()
    {
        $property = Property::where('status', 'active')->first();
        if (!$property) {
            $property = Property::first();
            $property->update(['status' => 'active']);
        }

        $result = $this->service->searchProperties($property->location, null, null, 'active');

        $this->assertGreaterThanOrEqual(1, $result->total());
        $this->assertEquals('active', $result->items()[0]->status);
    }

    /**
     * @group mvp
     */
    public function test_create_property()
    {
        $agent = User::where('role', 'agent')->first();
        if (!$agent) {
            $this->markTestSkipped('Agent missing');
        }

        $data = [
            'price' => 500000,
            'location' => 'Test Location',
            'status' => 'pending',
            'agent_id' => $agent->id,
        ];

        $property = $this->service->createProperty($data);

        $this->assertEquals('Test Location', $property->location);
        $this->assertEquals($agent->id, $property->agent_id);
        
        // Cleanup after test
        $property->delete();
    }
}
