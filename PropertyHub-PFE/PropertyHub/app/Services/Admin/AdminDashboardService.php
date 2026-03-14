<?php

namespace App\Services\Admin;

use App\Models\Appointment;
use App\Models\Property;
use App\Models\User;
use App\Models\Message;

class AdminDashboardService
{
    /**
     * Get dashboard overview statistics.
     * 
     * @return array
     */
    public function getDashboardOverview(): array
    {
        return [
            'total_properties' => Property::count(),
            'active_properties' => Property::where('status', 'active')->count(),
            'total_appointments' => Appointment::count(),
            'scheduled_appointments' => Appointment::where('status', 'scheduled')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'total_users' => User::count(),
            'total_agents' => User::where('role', 'agent')->count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
        ];
    }

    /**
     * Get property statistics for dashboard.
     * 
     * @return array
     */
    public function getPropertyStats(): array
    {
        return [
            'total' => Property::count(),
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'sold' => Property::where('status', 'sold')->count(),
            'average_price' => round(Property::avg('price'), 2),
            'highest_price' => Property::max('price'),
            'lowest_price' => Property::min('price'),
        ];
    }

    /**
     * Get appointment statistics for dashboard.
     * 
     * @return array
     */
    public function getAppointmentStats(): array
    {
        return [
            'total' => Appointment::count(),
            'scheduled' => Appointment::where('status', 'scheduled')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'no_show' => Appointment::where('status', 'no-show')->count(),
        ];
    }

    /**
     * Get user statistics for dashboard.
     * 
     * @return array
     */
    public function getUserStats(): array
    {
        return [
            'total' => User::count(),
            'agents' => User::where('role', 'agent')->count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];
    }

    /**
     * Get top agents by property count.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getTopAgents(int $limit = 5)
    {
        return User::where('role', 'agent')
            ->withCount('agentProperties')
            ->orderBy('agent_properties_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent properties.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getRecentProperties(int $limit = 10)
    {
        return Property::with('agent')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent appointments.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getRecentAppointments(int $limit = 10)
    {
        return Appointment::with('buyer', 'agent')
            ->orderBy('date_time', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get upcoming appointments.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getUpcomingAppointments(int $limit = 10)
    {
        return Appointment::where('date_time', '>=', now())
            ->where('status', 'scheduled')
            ->with('buyer', 'agent')
            ->orderBy('date_time', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent users.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getRecentUsers(int $limit = 10)
    {
        return User::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activity summary for the last 30 days.
     * 
     * @return array
     */
    public function getActivitySummary(): array
    {
        $thirtyDaysAgo = now()->subDays(30);

        return [
            'new_properties' => Property::where('created_at', '>=', $thirtyDaysAgo)->count(),
            'new_appointments' => Appointment::where('created_at', '>=', $thirtyDaysAgo)->count(),
            'new_users' => User::where('created_at', '>=', $thirtyDaysAgo)->count(),
            'completed_appointments' => Appointment::where('status', 'completed')
                ->where('updated_at', '>=', $thirtyDaysAgo)
                ->count(),
        ];
    }

    /**
     * Get properties by agent count.
     * Shows which agents have how many properties.
     * 
     * @return mixed
     */
    public function getAgentPropertyDistribution()
    {
        return User::where('role', 'agent')
            ->withCount('agentProperties')
            ->get()
            ->map(function ($agent) {
                return [
                    'agent_id' => $agent->id,
                    'agent_name' => $agent->name,
                    'property_count' => $agent->agent_properties_count,
                ];
            });
    }

    /**
     * Get system health check.
     * 
     * @return array
     */
    public function getSystemHealth(): array
    {
        $totalUsers = User::count();
        $activeAgents = User::where('role', 'agent')
            ->has('agentProperties')
            ->count();
        $activeProperties = Property::where('status', 'active')->count();
        $upcomingAppointments = Appointment::where('date_time', '>=', now())
            ->where('status', 'scheduled')
            ->count();

        return [
            'total_users' => $totalUsers,
            'active_agents' => $activeAgents,
            'active_properties' => $activeProperties,
            'upcoming_appointments' => $upcomingAppointments,
            'system_status' => 'operational',
        ];
    }
}
