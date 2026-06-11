<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\Revenue;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PropertyService
{
    /* -----------------------------------------------------------------
     | Public read paths
     | ----------------------------------------------------------------- */

    /**
     * Public listing: only approved properties, supports filters.
     */
    public function getPublicProperties(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Property::with(['images', 'agent', 'statusRelation'])
            ->whereHas('statusRelation', fn($q) => $q->where('name', 'approved'));

        $this->applyPublicFilters($query, $filters);

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Admin listing: all statuses, supports search and filters.
     */
    public function getAdminProperties(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Property::with(['agent', 'images', 'statusRelation']);

        if (!empty($filters['status'])) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $filters['status']));
        }

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('city', 'like', "%{$term}%")
                  ->orWhere('country', 'like', "%{$term}%")
                  ->orWhere('address', 'like', "%{$term}%")
                  ->orWhereHas('agent', fn($a) => $a->where('name', 'like', "%{$term}%"));
            });
        }

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest'     => $query->orderBy('created_at', 'asc'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Featured properties for homepage.
     */
    public function getFeaturedProperties(int $limit = 6): Collection
    {
        return Property::with('images', 'agent', 'statusRelation')
            ->whereHas('statusRelation', fn($q) => $q->where('name', 'approved'))
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Single property with all relations.
     */
    public function getPropertyById(int $id): Property
    {
        return Property::with(['images', 'agent', 'statusRelation'])->findOrFail($id);
    }

    /**
     * Get a property for a specific agent (for edit page authorization).
     */
    public function getAgentProperty(int $propertyId, int $agentId): Property
    {
        return Property::with('images')
            ->where('id', $propertyId)
            ->where('agent_id', $agentId)
            ->firstOrFail();
    }

    /**
     * List of properties the agent owns, paginated.
     */
    public function getAgentProperties(int $agentId, int $perPage = 15): LengthAwarePaginator
    {
        return Property::with('images')
            ->where('agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Compare list — looks up several properties by IDs in one shot.
     */
    public function getPropertiesByIds(array $ids): Collection
    {
        if (empty($ids)) {
            return new Collection();
        }
        return Property::with('images', 'statusRelation')
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Backward-compatible generic getter used by older tests.
     * Now filters by status name through the relation.
     */
    public function getProperties(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Property::with('agent', 'galleries', 'buyers');
        if ($status) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $status));
        }
        return $query->paginate($perPage);
    }

    /**
     * Backward-compatible search (location, minPrice, maxPrice, status).
     */
    public function searchProperties(
        ?string $location = null,
        ?int $minPrice = null,
        ?int $maxPrice = null,
        ?string $status = 'approved',
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = Property::with('agent', 'galleries');

        if ($status) {
            $query->whereHas('statusRelation', fn($q) => $q->where('name', $status));
        }

        if ($location) {
            $query->where(function ($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                  ->orWhere('country', 'like', "%{$location}%")
                  ->orWhere('address', 'like', "%{$location}%");
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

    /* -----------------------------------------------------------------
     | Write paths
     | ----------------------------------------------------------------- */

    public function createProperty(array $data): Property
    {
        return DB::transaction(function () use ($data) {
            $agent = User::findOrFail($data['agent_id']);
            if (!in_array($agent->role, ['agent', 'admin'], true)) {
                throw new \Exception("Selected user is not an agent.");
            }

            $property = new Property();
            $property->fill($data);
            if (empty($property->location)) {
                $property->location = trim(($data['city'] ?? '') . ', ' . ($data['country'] ?? ''), ', ');
            }
            if (!empty($data['status'])) {
                $property->status = $data['status'];
            }
            $property->save();

            \App\Models\ActivityLog::log('create_property', "Property listing '{$property->title}' was created by agent " . ($property->agent?->name ?? 'Unknown') . ".", $property->agent);

            if ($property->status === 'pending') {
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\PropertySubmitted($property));
                }
            }

            return $property;
        });
    }

    public function updateProperty(int $propertyId, array $data): Property
    {
        return DB::transaction(function () use ($propertyId, $data) {
            $property = Property::findOrFail($propertyId);

            if (isset($data['agent_id']) && $data['agent_id'] !== $property->agent_id) {
                $agent = User::findOrFail($data['agent_id']);
                if (!in_array($agent->role, ['agent', 'admin'], true)) {
                    throw new \Exception("Selected user is not an agent.");
                }
            }

            $property->fill($data);
            if (empty($property->location)) {
                $property->location = trim(($data['city'] ?? $property->city ?? '') . ', ' . ($data['country'] ?? $property->country ?? ''), ', ');
            }
            if (!empty($data['status'])) {
                $property->status = $data['status'];
            }
            $property->save();

            if ($property->status === 'pending') {
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\PropertySubmitted($property));
                }
            }

            return $property;
        });
    }

    public function deleteProperty(int $propertyId): void
    {
        DB::transaction(function () use ($propertyId) {
            $property = Property::findOrFail($propertyId);
            $property->delete();
        });
    }

    public function approveProperty(int $propertyId, ?string $note = null): Property
    {
        return DB::transaction(function () use ($propertyId, $note) {
            $property = Property::findOrFail($propertyId);
            $property->status = 'approved';
            $property->admin_note = $note;
            $property->save();

            \App\Models\ActivityLog::log('approve_property', "Property listing '{$property->title}' was approved by Admin" . ($note ? " with note: '{$note}'" : "") . ".");

            if ($property->agent) {
                $property->agent->notify(new \App\Notifications\PropertyStatusChanged($property, 'approved', $note));
            }

            return $property;
        });
    }

    public function rejectProperty(int $propertyId, ?string $note = null): Property
    {
        return DB::transaction(function () use ($propertyId, $note) {
            $property = Property::findOrFail($propertyId);
            $property->status = 'rejected';
            $property->admin_note = $note;
            $property->save();

            \App\Models\ActivityLog::log('reject_property', "Property listing '{$property->title}' was rejected by Admin" . ($note ? " with note: '{$note}'" : "") . ".");

            if ($property->agent) {
                $property->agent->notify(new \App\Notifications\PropertyStatusChanged($property, 'rejected', $note));
            }

            return $property;
        });
    }

    public function markAsSold(int $propertyId, ?string $note = null): Property
    {
        return DB::transaction(function () use ($propertyId, $note) {
            $property = Property::findOrFail($propertyId);
            $property->status = 'sold';
            $property->admin_note = $note;
            $property->save();

            Revenue::create([
                'property_id' => $property->id,
                'amount'      => $property->price,
                'type'        => 'sold',
                'agent_id'    => $property->agent_id,
            ]);

            \App\Models\ActivityLog::log('sell_property', "Property listing '{$property->title}' was marked as sold by Admin" . ($note ? " with note: '{$note}'" : "") . ". Revenue: \${$property->price}");

            if ($property->agent) {
                $property->agent->notify(new \App\Notifications\PropertyStatusChanged($property, 'sold', $note));
            }

            return $property;
        });
    }

    public function markAsRented(int $propertyId, ?string $note = null): Property
    {
        return DB::transaction(function () use ($propertyId, $note) {
            $property = Property::findOrFail($propertyId);
            $property->status = 'rented';
            $property->admin_note = $note;
            $property->save();

            Revenue::create([
                'property_id' => $property->id,
                'amount'      => $property->price,
                'type'        => 'rented',
                'agent_id'    => $property->agent_id,
            ]);

            \App\Models\ActivityLog::log('rent_property', "Property listing '{$property->title}' was marked as rented by Admin" . ($note ? " with note: '{$note}'" : "") . ". Revenue: \${$property->price}");

            if ($property->agent) {
                $property->agent->notify(new \App\Notifications\PropertyStatusChanged($property, 'rented', $note));
            }

            return $property;
        });
    }

    /* -----------------------------------------------------------------
     | Images
     | ----------------------------------------------------------------- */

    /**
     * Persist uploaded images into the gallery table for a property.
     */
    public function storeImages(Property $property, array $files): void
    {
        if (empty($files)) {
            return;
        }
        $urls = [];
        foreach ($files as $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
                $path = $file->store('properties', 'public');
                $urls[] = '/storage/' . $path;
            }
        }
        if (!empty($urls)) {
            $property->images()->create(['image_urls' => $urls]);
        }
    }

    public function deleteImages(Property $property, array $urlsToDelete): void
    {
        if (empty($urlsToDelete)) {
            return;
        }

        foreach ($property->images as $gallery) {
            $currentUrls = $gallery->image_urls;
            if (is_array($currentUrls)) {
                $newUrls = array_values(array_filter($currentUrls, function ($url) use ($urlsToDelete) {
                    return !in_array($url, $urlsToDelete);
                }));

                if (empty($newUrls)) {
                    $gallery->delete();
                } else {
                    $gallery->update(['image_urls' => $newUrls]);
                }
            }
        }
    }

    /* -----------------------------------------------------------------
     | Statistics
     | ----------------------------------------------------------------- */

    public function getPropertyStatistics(): array
    {
        $base = fn(string $name) => Property::whereHas('statusRelation', fn($q) => $q->where('name', $name))->count();

        return [
            'total'         => Property::count(),
            'approved'      => $base('approved'),
            'pending'       => $base('pending'),
            'rejected'      => $base('rejected'),
            'sold'          => $base('sold'),
            'rented'        => $base('rented'),
            'average_price' => round((float) Property::avg('price'), 2),
        ];
    }

    /**
     * Counts scoped to a specific agent.
     */
    public function getAgentStatistics(int $agentId): array
    {
        $byStatus = fn(string $name) => Property::where('agent_id', $agentId)
            ->whereHas('statusRelation', fn($q) => $q->where('name', $name))
            ->count();

        return [
            'total'        => Property::where('agent_id', $agentId)->count(),
            'approved'     => $byStatus('approved'),
            'pending'      => $byStatus('pending'),
            'rejected'     => $byStatus('rejected'),
            'new_this_week' => Property::where('agent_id', $agentId)
                ->where('created_at', '>=', now()->subWeek())
                ->count(),
        ];
    }

    /* -----------------------------------------------------------------
     | Lookups for forms
     | ----------------------------------------------------------------- */

    public function getAssignableAgents(): Collection
    {
        return User::whereIn('role', ['agent', 'admin'])
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    public function getAllStatuses(): array
    {
        return PropertyStatus::orderBy('name')->pluck('name')->toArray();
    }

    /* -----------------------------------------------------------------
     | Favorites (kept from old API)
     | ----------------------------------------------------------------- */

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

    /* -----------------------------------------------------------------
     | Internals
     | ----------------------------------------------------------------- */

    private function applyPublicFilters($query, array $filters): void
    {
        if (!empty($filters['price_range'])) {
            $range = $filters['price_range'];
            if (str_contains($range, '+')) {
                $filters['min_price'] = (int) str_replace('+', '', $range);
            } elseif (str_contains($range, '-')) {
                $parts = explode('-', $range, 2);
                $filters['min_price'] = (int) $parts[0];
                $filters['max_price'] = (int) $parts[1];
            }
        }

        if (!empty($filters['location'])) {
            $loc = $filters['location'];
            $query->where(function ($q) use ($loc) {
                $q->where('city', 'like', "%{$loc}%")
                  ->orWhere('country', 'like', "%{$loc}%")
                  ->orWhere('address', 'like', "%{$loc}%");
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

        $sort = $filters['sort'] ?? 'newest';
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->orderBy('created_at', 'desc'),
        };
    }
}
