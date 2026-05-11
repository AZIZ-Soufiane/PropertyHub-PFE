<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PropertyService
{
    /**
     * Get properties with optional status filtering.
     * Works for both public (active only) and admin (all).
     */
    public function getProperties(string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Property::with('agent', 'galleries', 'buyers');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get a single property with all details.
     */
    public function getPropertyDetails(int $id): Property
    {
        return Property::with('agent', 'galleries', 'buyers')
            ->findOrFail($id);
    }

    /**
     * Search properties by location and price range.
     */
    public function searchProperties(
        string $location = null,
        int $minPrice = null,
        int $maxPrice = null,
        string $status = 'active',
        int $perPage = 15
    ): LengthAwarePaginator
    {
        $query = Property::with('agent', 'galleries');

        if ($status) {
            $query->where('status', $status);
        }

        if ($location) {
            $query->where('location', 'like', '%' . $location . '%');
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->paginate($perPage);
    }

    /**
     * Create a new property (Admin/Agent).
     */
    public function createProperty(array $data): Property
    {
        return DB::transaction(function () use ($data) {
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
     */
    public function updateProperty(int $propertyId, array $data): Property
    {
        return DB::transaction(function () use ($propertyId, $data) {
            $property = Property::findOrFail($propertyId);

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
     */
    public function deleteProperty(int $propertyId): void
    {
        $property = Property::findOrFail($propertyId);
        $property->delete();
    }

    /**
     * Favorite management.
     */
    public function addToFavorites(int $buyerId, int $propertyId): void
    {
        $buyer = User::findOrFail($buyerId);
        if (!$buyer->favorites()->where('property_id', $propertyId)->exists()) {
            $buyer->favorites()->attach($propertyId);
        }
    }

    public function removeFromFavorites(int $buyerId, int $propertyId): void
    {
        $buyer = User::findOrFail($buyerId);
        $buyer->favorites()->detach($propertyId);
    }

    public function isFavorited(int $buyerId, int $propertyId): bool
    {
        $buyer = User::findOrFail($buyerId);
        return $buyer->favorites()->where('property_id', $propertyId)->exists();
    }

    /**
     * Statistics.
     */
    public function getPropertyStatistics(): array
    {
        return [
            'total' => Property::count(),
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'sold' => Property::where('status', 'sold')->count(),
            'average_price' => round(Property::avg('price'), 2),
        ];
    }
}
