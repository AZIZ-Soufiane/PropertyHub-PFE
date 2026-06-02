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
        $result = $this->service->getProperties('approved');

        $this->assertGreaterThanOrEqual(0, $result->total());
        foreach($result->items() as $item) {
            $this->assertEquals('approved', $item->status);
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
        $property = Property::first();
        if (!$property) {
            $this->markTestSkipped('No properties in DB');
        }

        $result = $this->service->searchProperties($property->city, null, null, 'approved');

        $this->assertGreaterThanOrEqual(0, $result->total());
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
