<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Services\Admin\AdminUserService;

class AdminUserServiceTest extends TestCase
{
    protected AdminUserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminUserService();
    }

    public function test_get_all_users()
    {
        User::factory()->count(5)->create();

        $result = $this->service->getAllUsers(15);

        $this->assertGreaterThanOrEqual(5, count($result->items()));
    }

    public function test_get_users_by_role()
    {
        User::factory()->count(3)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'buyer']);

        $result = $this->service->getUsersByRole('agent');

        $this->assertCount(3, $result->items());
    }

    public function test_get_users_by_role_throws_exception_for_invalid_role()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid role");

        $this->service->getUsersByRole('invalid');
    }

    public function test_get_user_details()
    {
        $user = User::factory()->create();

        $result = $this->service->getUserDetails($user->id);

        $this->assertEquals($user->id, $result->id);
    }

    public function test_create_user()
    {
        $user = $this->service->createUser([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'agent',
            'license_number' => 'LIC123',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('agent', $user->role);
    }

    public function test_create_user_throws_exception_for_duplicate_email()
    {
        $user = User::factory()->create(['email' => 'existing@example.com']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Email already exists");

        $this->service->createUser([
            'name' => 'Jane Doe',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'role' => 'buyer',
        ]);
    }

    public function test_create_user_throws_exception_for_invalid_role()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid role");

        $this->service->createUser([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'role' => 'invalid',
        ]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();

        $updated = $this->service->updateUser($user->id, [
            'name' => 'Updated Name',
        ]);

        $this->assertEquals('Updated Name', $updated->name);
    }

    public function test_update_user_throws_exception_for_duplicate_email()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Email already exists");

        $this->service->updateUser($user2->id, [
            'email' => 'user1@example.com',
        ]);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();

        $this->service->deleteUser($user->id);

        $this->assertNull(User::find($user->id));
    }

    public function test_get_all_agents()
    {
        User::factory()->count(3)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'buyer']);

        $result = $this->service->getAllAgents();

        $this->assertCount(3, $result->items());
    }

    public function test_get_all_buyers()
    {
        User::factory()->count(3)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'buyer']);

        $result = $this->service->getAllBuyers();

        $this->assertCount(2, $result->items());
    }

    public function test_search_users()
    {
        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $result = $this->service->searchUsers('John');

        $this->assertCount(1, $result->items());
    }

    public function test_get_user_statistics()
    {
        User::factory()->count(1)->create(['role' => 'admin']);
        User::factory()->count(3)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'buyer']);

        $stats = $this->service->getUserStatistics();

        $this->assertGreaterThan(0, $stats['total']);
        $this->assertGreaterThan(0, $stats['agents']);
        $this->assertGreaterThan(0, $stats['buyers']);
    }

    public function test_assign_role()
    {
        $user = User::factory()->create(['role' => 'buyer']);

        $updated = $this->service->assignRole($user->id, 'agent');

        $this->assertEquals('agent', $updated->role);
    }

    public function test_reset_password()
    {
        $user = User::factory()->create();
        $oldPassword = $user->password;

        $this->service->resetPassword($user->id, 'newpassword123');

        $updated = User::find($user->id);
        $this->assertNotEquals($oldPassword, $updated->password);
    }
}
