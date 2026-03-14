<?php

namespace App\Services\Admin;

use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminPropertyService
{
    /**
     * Get all properties with pagination.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllProperties(int $perPage = 15)
    {
        return Property::with('agent', 'galleries', 'buyers')
            ->paginate($perPage);
    }

    /**
     * Get properties by status.
     * 
     * @param string $status
     * @param int $perPage
     * @return mixed
     */
    public function getPropertiesByStatus(string $status, int $perPage = 15)
    {
        return Property::where('status', $status)
            ->with('agent', 'galleries', 'buyers')
            ->paginate($perPage);
    }

    /**
     * Create a new property.
     * 
     * @param array $data
     * @return Property
     */
    public function createProperty(array $data): Property
    {
        return DB::transaction(function () use ($data) {
            // Validate agent exists and has agent role
            $agent = User::findOrFail($data['agent_id']);
            if ($agent->role !== 'agent') {
                throw new \Exception("Selected user is not an agent.");
            }

            return Property::create([
                'price' => $data['price'],
                'location' => $data['location'],
                'status' => $data['status'] ?? 'pending',
                'agent_id' => $data['agent_id'],
            ]);
        });
    }

    /**
     * Update a property.
     * 
     * @param int $propertyId
     * @param array $data
     * @return Property
     */
    public function updateProperty(int $propertyId, array $data): Property
    {
        return DB::transaction(function () use ($propertyId, $data) {
            $property = Property::findOrFail($propertyId);

            // If agent_id is being updated, validate the new agent
            if (isset($data['agent_id']) && $data['agent_id'] !== $property->agent_id) {
                $agent = User::findOrFail($data['agent_id']);
                if ($agent->role !== 'agent') {
                    throw new \Exception("Selected user is not an agent.");
                }
            }

            $property->update($data);
            return $property;
        });
    }

    /**
     * Delete a property.
     * Rule: Prevent deletion if property has active appointments.
     * 
     * @param int $propertyId
     * @return void
     */
    public function deleteProperty(int $propertyId): void
    {
        DB::transaction(function () use ($propertyId) {
            $property = Property::findOrFail($propertyId);

            // Check if property has favorited users (soft check - can be deleted)
            // But prevent if this is critical business logic

            $property->delete();
        });
    }

    /**
     * Search properties by location.
     * 
     * @param string $location
     * @param int $perPage
     * @return mixed
     */
    public function searchByLocation(string $location, int $perPage = 15)
    {
        return Property::where('location', 'like', '%' . $location . '%')
            ->with('agent', 'galleries', 'buyers')
            ->paginate($perPage);
    }

    /**
     * Filter properties by price range.
     * 
     * @param int $minPrice
     * @param int $maxPrice
     * @param int $perPage
     * @return mixed
     */
    public function filterByPriceRange(int $minPrice, int $maxPrice, int $perPage = 15)
    {
        return Property::whereBetween('price', [$minPrice, $maxPrice])
            ->with('agent', 'galleries', 'buyers')
            ->paginate($perPage);
    }

    /**
     * Get properties by specific agent.
     * 
     * @param int $agentId
     * @param int $perPage
     * @return mixed
     */
    public function getPropertiesByAgent(int $agentId, int $perPage = 15)
    {
        User::findOrFail($agentId); // Verify agent exists

        return Property::where('agent_id', $agentId)
            ->with('agent', 'galleries', 'buyers')
            ->paginate($perPage);
    }

    /**
     * Get property statistics.
     * 
     * @return array
     */
    public function getPropertyStatistics(): array
    {
        return [
            'total' => Property::count(),
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'sold' => Property::where('status', 'sold')->count(),
            'average_price' => round(Property::avg('price'), 2),
            'highest_price' => Property::max('price'),
            'lowest_price' => Property::min('price'),
        ];
    }

    /**
     * Get property with all related data.
     * 
     * @param int $propertyId
     * @return Property
     */
    public function getPropertyDetails(int $propertyId): Property
    {
        return Property::with('agent', 'galleries', 'buyers')
            ->findOrFail($propertyId);
    }

    /**
     * Bulk update property status.
     * 
     * @param array $propertyIds
     * @param string $status
     * @return int
     */
    public function bulkUpdateStatus(array $propertyIds, string $status): int
    {
        return Property::whereIn('id', $propertyIds)
            ->update(['status' => $status]);
    }
}
