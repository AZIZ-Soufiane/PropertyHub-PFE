<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get users with pagination and optional role filter.
     */
    public function getUsers(string $role = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = User::with('agentProperties', 'calendar');
        if ($role) {
            $query->where('role', $role);
        }
        return $query->paginate($perPage);
    }

    /**
     * Create/Update User.
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            if (User::where('email', $data['email'])->exists()) {
                throw new \Exception("Email already exists.");
            }

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'license_number' => $data['license_number'] ?? null,
            ]);
        });
    }

    public function updateUser(int $userId, array $data): User
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = User::findOrFail($userId);

            if (isset($data['email']) && $data['email'] !== $user->email) {
                if (User::where('email', $data['email'])->exists()) {
                    throw new \Exception("Email already exists.");
                }
            }

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);
            return $user;
        });
    }

    /**
     * Role assignments.
     */
    public function assignRole(int $userId, string $role): User
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => $role]);
        return $user;
    }

    /**
     * Soft-validation deletion.
     */
    public function deleteUser(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $user = User::findOrFail($userId);

            // Business logic check
            if ($user->role === 'agent' && $user->agentProperties()->count() > 0) {
                throw new \Exception("Cannot delete agent with active properties.");
            }

            $user->delete();
        });
    }
}
