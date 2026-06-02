<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PropertyService
{
    public function getProperties(string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Property::with('agent', 'galleries', 'buyers');

        if ($status) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $status));
        }

        return $query->paginate($perPage);
    }

    public function getPropertyDetails(int $id): Property
    {
        return Property::with('agent', 'galleries', 'buyers', 'statusRelation')
            ->findOrFail($id);
    }

    public function searchProperties(
        ?string $location = null,
        ?int $minPrice = null,
        ?int $maxPrice = null,
        string $status = 'approved',
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = Property::with('agent', 'galleries', 'statusRelation');

        if ($status) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $status));
        }

        if ($location) {
            $query->where(function ($q) use ($location) {
                $q->where('location', 'like', '%' . $location . '%')
                  ->orWhere('city', 'like', '%' . $location . '%')
                  ->orWhere('country', 'like', '%' . $location . '%')
                  ->orWhere('address', 'like', '%' . $location . '%');
            });
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->paginate($perPage);
    }

    public function searchAndFilter(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Property::with('images', 'agent', 'statusRelation');

        if (!empty($filters['status'])) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $filters['status']));
        }

        if (!empty($filters['location'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('city', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('country', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('address', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('location', 'like', '%' . $filters['location'] . '%');
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['bedrooms'])) {
            $query->where('bedrooms', '>=', $filters['bedrooms']);
        }

        if (!empty($filters['bathrooms'])) {
            $query->where('bathrooms', '>=', $filters['bathrooms']);
        }

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($perPage);
    }

    public function getFeaturedProperties(int $limit = 6)
    {
        return Property::with('images', 'agent', 'statusRelation')
            ->whereHas('statusRelation', fn($q) => $q->where('name', 'approved'))
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getPropertiesForComparison(array $ids)
    {
        return Property::with('images', 'agent', 'statusRelation')
            ->whereIn('id', $ids)
            ->get();
    }

    public function createProperty(array $data): Property
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['agent_id'])) {
                $agent = User::findOrFail($data['agent_id']);
                if ($agent->role !== 'agent' && $agent->role !== 'admin') {
                    throw new \Exception("Selected user is not an agent.");
                }
            }

            $property = new Property();
            $property->fill(array_diff_key($data, array_flip(['status'])));
            if (isset($data['status'])) {
                $property->status = $data['status'];
            }
            $property->save();
            return $property;
        });
    }

    public function updateProperty(int $propertyId, array $data): Property
    {
        return DB::transaction(function () use ($propertyId, $data) {
            $property = Property::findOrFail($propertyId);

            if (isset($data['agent_id']) && $data['agent_id'] !== $property->agent_id) {
                $agent = User::findOrFail($data['agent_id']);
                if ($agent->role !== 'agent' && $agent->role !== 'admin') {
                    throw new \Exception("Selected user is not an agent.");
                }
            }

            $property->fill(array_diff_key($data, array_flip(['status'])));
            if (isset($data['status'])) {
                $property->status = $data['status'];
            }
            $property->save();
            return $property;
        });
    }

    public function deleteProperty(int $propertyId): void
    {
        $property = Property::findOrFail($propertyId);
        $property->delete();
    }

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

    public function getPropertyStatistics(): array
    {
        return [
            'total' => Property::count(),
            'approved' => Property::whereHas('statusRelation', fn($q) => $q->where('name', 'approved'))->count(),
            'pending' => Property::whereHas('statusRelation', fn($q) => $q->where('name', 'pending'))->count(),
            'rejected' => Property::whereHas('statusRelation', fn($q) => $q->where('name', 'rejected'))->count(),
            'sold' => Property::whereHas('statusRelation', fn($q) => $q->where('name', 'sold'))->count(),
            'average_price' => round(Property::avg('price'), 2),
        ];
    }
}
