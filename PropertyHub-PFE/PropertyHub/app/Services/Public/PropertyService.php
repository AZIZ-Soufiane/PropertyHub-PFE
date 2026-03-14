<?php

namespace App\Services\Public;

use App\Models\Property;
use App\Models\User;
use Illuminate\Pagination\Paginator;

class PropertyService
{
    /**
     * Get all active properties for public listing.
     * 
     * @param int $perPage
     * @return Paginator
     */
    public function getAllActiveProperties(int $perPage = 15)
    {
        return Property::where('status', 'active')
            ->with('agent', 'galleries')
            ->paginate($perPage);
    }

    /**
     * Get a single property with all details.
     * 
     * @param int $id
     * @return Property
     */
    public function getPropertyDetails(int $id): Property
    {
        return Property::with('agent', 'galleries', 'buyers')
            ->findOrFail($id);
    }

    /**
     * Search properties by location and price range.
     * 
     * @param string $location
     * @param int|null $minPrice
     * @param int|null $maxPrice
     * @param int $perPage
     * @return Paginator
     */
    public function searchProperties(
        string $location = null,
        int $minPrice = null,
        int $maxPrice = null,
        int $perPage = 15
    ): Paginator
    {
        $query = Property::where('status', 'active')
            ->with('agent', 'galleries');

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
     * Get properties by agent.
     * 
     * @param int $agentId
     * @param int $perPage
     * @return Paginator
     */
    public function getPropertiesByAgent(int $agentId, int $perPage = 15): Paginator
    {
        return Property::where('agent_id', $agentId)
            ->where('status', 'active')
            ->with('agent', 'galleries')
            ->paginate($perPage);
    }

    /**
     * Get buyer's favorite properties.
     * 
     * @param int $buyerId
     * @param int $perPage
     * @return Paginator
     */
    public function getBuyerFavorites(int $buyerId, int $perPage = 15): Paginator
    {
        $buyer = User::findOrFail($buyerId);
        return $buyer->favorites()->with('agent', 'galleries')->paginate($perPage);
    }

    /**
     * Add property to buyer's favorites.
     * 
     * @param int $buyerId
     * @param int $propertyId
     * @return void
     */
    public function addToFavorites(int $buyerId, int $propertyId): void
    {
        $buyer = User::findOrFail($buyerId);
        $property = Property::findOrFail($propertyId);

        if (!$buyer->favorites()->where('property_id', $propertyId)->exists()) {
            $buyer->favorites()->attach($propertyId);
        }
    }

    /**
     * Remove property from buyer's favorites.
     * 
     * @param int $buyerId
     * @param int $propertyId
     * @return void
     */
    public function removeFromFavorites(int $buyerId, int $propertyId): void
    {
        $buyer = User::findOrFail($buyerId);
        $buyer->favorites()->detach($propertyId);
    }

    /**
     * Check if property is in buyer's favorites.
     * 
     * @param int $buyerId
     * @param int $propertyId
     * @return bool
     */
    public function isFavorited(int $buyerId, int $propertyId): bool
    {
        $buyer = User::findOrFail($buyerId);
        return $buyer->favorites()->where('property_id', $propertyId)->exists();
    }

    /**
     * Get properties by status.
     * 
     * @param string $status
     * @param int $perPage
     * @return Paginator
     */
    public function getPropertiesByStatus(string $status, int $perPage = 15): Paginator
    {
        return Property::where('status', $status)
            ->with('agent', 'galleries')
            ->paginate($perPage);
    }
}
