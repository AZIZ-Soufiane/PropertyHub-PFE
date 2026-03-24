<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;

class UserServiceTest extends TestCase
{
    protected UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new UserService();
    }

    /**
     * @group mvp
     */
    public function test_get_users_by_role_using_real_db()
    {
        $result = $this->service->getUsers('agent');

        $this->assertGreaterThanOrEqual(1, $result->total());
        foreach($result->items() as $item) {
            $this->assertEquals('agent', $item->role);
        }
    }

    /**
     * @group mvp
     */
    public function test_create_user_using_real_db()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'unique_test@example.com',
            'password' => 'password123',
            'role' => 'buyer',
            'license_number' => null,
        ];

        $user = $this->service->createUser($data);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('unique_test@example.com', $user->email);
        $this->assertEquals('buyer', $user->role);
        
        // Cleanup
        $user->delete();
    }
}
