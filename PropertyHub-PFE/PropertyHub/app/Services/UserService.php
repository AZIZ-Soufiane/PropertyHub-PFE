<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /* -----------------------------------------------------------------
     | Read paths
     | ----------------------------------------------------------------- */

    public function getUsers(array|string $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        if (is_string($filters)) {
            $filters = ['role' => $filters];
        }

        $query = User::query();

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
    }

    /**
     * Backward-compatible single-filter getter.
     */
    public function getUsersByRole(string $role, int $perPage = 15): LengthAwarePaginator
    {
        return User::where('role', $role)->paginate($perPage);
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Platform-wide statistics for the admin dashboard.
     */
    public function getUserStatistics(): array
    {
        return [
            'total'              => User::count(),
            'new_this_month'     => User::where('created_at', '>=', now()->startOfMonth())->count(),
            'admins'             => User::where('role', 'admin')->count(),
            'agents'             => User::where('role', 'agent')->count(),
            'buyers'             => User::where('role', 'buyer')->count(),
        ];
    }

    /* -----------------------------------------------------------------
     | Write paths
     | ----------------------------------------------------------------- */

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            if (User::where('email', $data['email'])->exists()) {
                throw new \Exception("Email already exists.");
            }

            $user = User::create([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'password'       => Hash::make($data['password']),
                'role'           => $data['role'] ?? 'buyer',
                'license_number' => $data['license_number'] ?? null,
            ]);

            \App\Models\ActivityLog::log('create_user', "User account for {$user->name} (" . ucfirst($user->role) . ") was created.", $user);
            return $user;
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

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);
            \App\Models\ActivityLog::log('update_user', "User account for {$user->name} was updated.");
            return $user;
        });
    }

    public function assignRole(int $userId, string $role): User
    {
        $user = User::findOrFail($userId);
        $user->update(['role' => $role]);
        \App\Models\ActivityLog::log('assign_role', "Assigned role '" . ucfirst($role) . "' to user {$user->name}.");
        return $user;
    }

    public function deleteUser(int $userId, ?int $currentUserId = null): void
    {
        DB::transaction(function () use ($userId, $currentUserId) {
            $user = User::findOrFail($userId);

            if ($currentUserId !== null && $user->id === $currentUserId) {
                throw new \Exception("You cannot delete yourself.");
            }

            if ($user->role === 'agent' && $user->agentProperties()->count() > 0) {
                throw new \Exception("Cannot delete agent with active properties.");
            }

            \App\Models\ActivityLog::log('delete_user', "User account for {$user->name} (" . ucfirst($user->role) . ") was deleted.");
            $user->delete();
        });
    }
}
