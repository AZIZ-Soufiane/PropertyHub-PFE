<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserService
{
    /**
     * Get all users with pagination.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllUsers(int $perPage = 15)
    {
        return User::with('agentProperties', 'calendar', 'appointmentsAsAgent', 'appointmentsAsBuyer')
            ->paginate($perPage);
    }

    /**
     * Get users by role.
     * 
     * @param string $role
     * @param int $perPage
     * @return mixed
     */
    public function getUsersByRole(string $role, int $perPage = 15)
    {
        $validRoles = ['admin', 'agent', 'buyer'];
        if (!in_array($role, $validRoles)) {
            throw new \Exception("Invalid role: " . $role);
        }

        return User::where('role', $role)
            ->with('agentProperties', 'calendar', 'appointmentsAsAgent', 'appointmentsAsBuyer')
            ->paginate($perPage);
    }

    /**
     * Get user details.
     * 
     * @param int $userId
     * @return User
     */
    public function getUserDetails(int $userId): User
    {
        return User::with('agentProperties', 'calendar', 'appointmentsAsAgent', 'appointmentsAsBuyer', 'favorites')
            ->findOrFail($userId);
    }

    /**
     * Create a new user.
     * 
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // Check if email already exists
            if (User::where('email', $data['email'])->exists()) {
                throw new \Exception("Email already exists.");
            }

            // Validate role
            $validRoles = ['admin', 'agent', 'buyer'];
            if (!in_array($data['role'], $validRoles)) {
                throw new \Exception("Invalid role: " . $data['role']);
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

    /**
     * Update user information.
     * 
     * @param int $userId
     * @param array $data
     * @return User
     */
    public function updateUser(int $userId, array $data): User
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = User::findOrFail($userId);

            // Check if email is being changed and if it already exists
            if (isset($data['email']) && $data['email'] !== $user->email) {
                if (User::where('email', $data['email'])->exists()) {
                    throw new \Exception("Email already exists.");
                }
            }

            // Validate role if provided
            if (isset($data['role'])) {
                $validRoles = ['admin', 'agent', 'buyer'];
                if (!in_array($data['role'], $validRoles)) {
                    throw new \Exception("Invalid role: " . $data['role']);
                }
            }

            // Hash password if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);
            return $user;
        });
    }

    /**
     * Delete a user.
     * Rule: Prevent deletion if user has active appointments or properties.
     * 
     * @param int $userId
     * @return void
     */
    public function deleteUser(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $user = User::findOrFail($userId);

            // Check for active appointments
            $activeAppointments = $user->appointmentsAsAgent()->orWhere('buyer_id', $user->id)->count();
            if ($activeAppointments > 0) {
                throw new \Exception("Cannot delete user with active appointments.");
            }

            // Check for agent properties
            if ($user->role === 'agent' && $user->agentProperties()->count() > 0) {
                throw new \Exception("Cannot delete agent with active properties.");
            }

            $user->delete();
        });
    }

    /**
     * Get all agents.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllAgents(int $perPage = 15)
    {
        return User::where('role', 'agent')
            ->with('agentProperties', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get all buyers.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllBuyers(int $perPage = 15)
    {
        return User::where('role', 'buyer')
            ->with('appointmentsAsBuyer', 'favorites')
            ->paginate($perPage);
    }

    /**
     * Search users by name or email.
     * 
     * @param string $query
     * @param int $perPage
     * @return mixed
     */
    public function searchUsers(string $query, int $perPage = 15)
    {
        return User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->with('agentProperties', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get user statistics.
     * 
     * @return array
     */
    public function getUserStatistics(): array
    {
        return [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'buyers' => User::where('role', 'buyer')->count(),
        ];
    }

    /**
     * Assign role to user.
     * 
     * @param int $userId
     * @param string $role
     * @return User
     */
    public function assignRole(int $userId, string $role): User
    {
        $validRoles = ['admin', 'agent', 'buyer'];
        if (!in_array($role, $validRoles)) {
            throw new \Exception("Invalid role: " . $role);
        }

        $user = User::findOrFail($userId);
        $user->update(['role' => $role]);
        return $user;
    }

    /**
     * Reset user password.
     * 
     * @param int $userId
     * @param string $newPassword
     * @return User
     */
    public function resetPassword(int $userId, string $newPassword): User
    {
        $user = User::findOrFail($userId);
        $user->update(['password' => Hash::make($newPassword)]);
        return $user;
    }
}
