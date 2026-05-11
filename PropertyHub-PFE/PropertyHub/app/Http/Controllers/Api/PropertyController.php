<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService)
    {
    }

    /**
     * Get all properties (paginated)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status', 'active');
        
        $properties = $this->propertyService->getProperties($status, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => PropertyResource::collection($properties),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
                'last_page' => $properties->lastPage(),
            ]
        ]);
    }

    /**
     * Get property details
     */
    public function show(int $id): JsonResponse
    {
        try {
            $property = $this->propertyService->getPropertyDetails($id);
            return response()->json([
                'status' => 'success',
                'data' => new PropertyResource($property),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Property not found',
            ], 404);
        }
    }

    /**
     * Search properties
     */
    public function search(Request $request): JsonResponse
    {
        $location = $request->get('location');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $status = $request->get('status', 'active');
        $perPage = $request->get('per_page', 15);

        $properties = $this->propertyService->searchProperties(
            $location,
            $minPrice,
            $maxPrice,
            $status,
            $perPage
        );

        return response()->json([
            'status' => 'success',
            'data' => PropertyResource::collection($properties),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
                'last_page' => $properties->lastPage(),
            ]
        ]);
    }

    /**
     * Get property details with all relationships
     */
    public function getDetails(int $id): JsonResponse
    {
        try {
            $property = $this->propertyService->getPropertyDetails($id);
            return response()->json([
                'status' => 'success',
                'data' => new PropertyResource($property),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Property not found',
            ], 404);
        }
    }

    /**
     * Add to favorites
     */
    public function addFavorite(int $propertyId, Request $request): JsonResponse
    {
        try {
            $userId = auth()->id();
            $this->propertyService->addToFavorites($userId, $propertyId);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Added to favorites',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove from favorites
     */
    public function removeFavorite(int $propertyId, Request $request): JsonResponse
    {
        try {
            $userId = auth()->id();
            $this->propertyService->removeFromFavorites($userId, $propertyId);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Removed from favorites',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get user's favorite properties
     */
    public function getFavorites(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $user = \App\Models\User::findOrFail($userId);
        $favorites = $user->favorites()->paginate($request->get('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => PropertyResource::collection($favorites),
            'meta' => [
                'current_page' => $favorites->currentPage(),
                'per_page' => $favorites->perPage(),
                'total' => $favorites->total(),
                'last_page' => $favorites->lastPage(),
            ]
        ]);
    }

    /**
     * Get properties by agent
     */
    public function getByAgent(int $agentId, Request $request): JsonResponse
    {
        $properties = \App\Models\Property::where('agent_id', $agentId)
            ->where('status', 'active')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'status' => 'success',
            'data' => PropertyResource::collection($properties),
            'meta' => [
                'current_page' => $properties->currentPage(),
                'per_page' => $properties->perPage(),
                'total' => $properties->total(),
                'last_page' => $properties->lastPage(),
            ]
        ]);
    }

    /**
     * Get property statistics
     */
    public function getStatistics(): JsonResponse
    {
        $stats = $this->propertyService->getPropertyStatistics();
        
        return response()->json([
            'status' => 'success',
            'data' => $stats,
        ]);
    }

    /**
     * Create a new property (Admin/Agent only)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric',
            'location' => 'required|string',
            'status' => 'nullable|in:pending,active,sold',
            'agent_id' => 'required|exists:users,id',
        ]);

        try {
            $property = $this->propertyService->createProperty($request->all());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Property created successfully',
                'data' => new PropertyResource($property),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update a property
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'nullable|numeric',
            'location' => 'nullable|string',
            'status' => 'nullable|in:pending,active,sold',
        ]);

        try {
            $property = $this->propertyService->updateProperty($id, $request->all());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Property updated successfully',
                'data' => new PropertyResource($property),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete a property
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->propertyService->deleteProperty($id);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Property deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
