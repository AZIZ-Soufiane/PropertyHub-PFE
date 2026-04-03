<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get user by ID
     */
    public function show(int $userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);
            return response()->json([
                'status' => 'success',
                'data' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);

        try {
            $user = auth()->user();
            $user->update($request->only(['name', 'phone', 'avatar_url']));

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get all agents
     */
    public function getAgents(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        
        try {
            $agents = User::where('role', 'agent')->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => UserResource::collection($agents),
                'meta' => [
                    'current_page' => $agents->currentPage(),
                    'per_page' => $agents->perPage(),
                    'total' => $agents->total(),
                    'last_page' => $agents->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
