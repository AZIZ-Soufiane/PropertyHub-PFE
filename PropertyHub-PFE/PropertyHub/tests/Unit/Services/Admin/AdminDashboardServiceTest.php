<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\Property;
use App\Models\User;
use App\Services\Admin\AdminDashboardService;

class AdminDashboardServiceTest extends TestCase
{
    protected AdminDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminDashboardService();
    }

    public function test_get_dashboard_overview()
    {
        Property::factory()->count(5)->create();
        Appointment::factory()->count(3)->create();

        $overview = $this->service->getDashboardOverview();

        $this->assertIsArray($overview);
        $this->assertArrayHasKey('total_properties', $overview);
        $this->assertArrayHasKey('total_appointments', $overview);
        $this->assertArrayHasKey('total_users', $overview);
    }

    public function test_get_property_stats()
    {
        Property::factory()->count(4)->create(['status' => 'active', 'price' => 500000]);
        Property::factory()->count(2)->create(['status' => 'sold', 'price' => 600000]);

        $stats = $this->service->getPropertyStats();

        $this->assertEquals(6, $stats['total']);
        $this->assertEquals(4, $stats['active']);
        $this->assertEquals(2, $stats['sold']);
    }

    public function test_get_appointment_stats()
    {
        Appointment::factory()->count(3)->create(['status' => 'scheduled']);
        Appointment::factory()->count(2)->create(['status' => 'completed']);

        $stats = $this->service->getAppointmentStats();

        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(3, $stats['scheduled']);
        $this->assertEquals(2, $stats['completed']);
    }

    public function test_get_user_stats()
    {
        User::factory()->count(1)->create(['role' => 'admin']);
        User::factory()->count(3)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'buyer']);

        $stats = $this->service->getUserStats();

        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('agents', $stats);
        $this->assertArrayHasKey('buyers', $stats);
    }

    public function test_get_top_agents()
    {
        $agent1 = User::factory()->create(['role' => 'agent']);
        $agent2 = User::factory()->create(['role' => 'agent']);

        Property::factory()->count(5)->create(['agent_id' => $agent1->id]);
        Property::factory()->count(3)->create(['agent_id' => $agent2->id]);

        $topAgents = $this->service->getTopAgents(5);

        $this->assertGreaterThan(0, count($topAgents));
    }

    public function test_get_recent_properties()
    {
        Property::factory()->count(5)->create();

        $recent = $this->service->getRecentProperties(10);

        $this->assertCount(5, $recent);
    }

    public function test_get_recent_appointments()
    {
        Appointment::factory()->count(5)->create();

        $recent = $this->service->getRecentAppointments(10);

        $this->assertCount(5, $recent);
    }

    public function test_get_upcoming_appointments()
    {
        Appointment::factory()->count(2)->create([
            'date_time' => now()->addDays(1),
            'status' => 'scheduled',
        ]);
        Appointment::factory()->count(1)->create([
            'date_time' => now()->subDays(1),
            'status' => 'scheduled',
        ]);

        $upcoming = $this->service->getUpcomingAppointments();

        $this->assertCount(2, $upcoming);
    }

    public function test_get_recent_users()
    {
        User::factory()->count(5)->create();

        $recent = $this->service->getRecentUsers(10);

        $this->assertGreaterThan(0, count($recent));
    }

    public function test_get_activity_summary()
    {
        Property::factory()->count(2)->create();
        Appointment::factory()->count(3)->create();
        User::factory()->count(1)->create();

        $summary = $this->service->getActivitySummary();

        $this->assertIsArray($summary);
        $this->assertArrayHasKey('new_properties', $summary);
        $this->assertArrayHasKey('new_appointments', $summary);
        $this->assertArrayHasKey('new_users', $summary);
    }

    public function test_get_agent_property_distribution()
    {
        $agent1 = User::factory()->create(['role' => 'agent']);
        $agent2 = User::factory()->create(['role' => 'agent']);

        Property::factory()->count(5)->create(['agent_id' => $agent1->id]);
        Property::factory()->count(3)->create(['agent_id' => $agent2->id]);

        $distribution = $this->service->getAgentPropertyDistribution();

        $this->assertGreaterThan(0, count($distribution));
    }

    public function test_get_system_health()
    {
        Property::factory()->count(5)->create(['status' => 'active']);
        Appointment::factory()->count(3)->create([
            'date_time' => now()->addDays(1),
            'status' => 'scheduled',
        ]);

        $health = $this->service->getSystemHealth();

        $this->assertIsArray($health);
        $this->assertArrayHasKey('system_status', $health);
        $this->assertEquals('operational', $health['system_status']);
    }
}
