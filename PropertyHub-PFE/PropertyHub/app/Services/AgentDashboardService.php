<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Appointment;
use App\Models\Message;
use Carbon\Carbon;

class AgentDashboardService
{
    public function getDashboardData(int $agentId): array
    {
        $stats = [
            'active_listings' => Property::where('agent_id', $agentId)
                ->whereHas('statusRelation', fn($q) => $q->where('name', 'approved'))
                ->count(),
            'pending_viewings' => Appointment::where('agent_id', $agentId)
                ->where('status', 'pending')
                ->whereDate('date_time', Carbon::today())
                ->count(),
            'total_appointments' => Appointment::where('agent_id', $agentId)->count(),
            'unread_messages' => Message::where('receiver_id', $agentId)
                ->whereNull('read_at')
                ->count(),
            'new_this_week' => Property::where('agent_id', $agentId)
                ->where('created_at', '>=', Carbon::now()->subWeek())
                ->count(),
        ];

        $upcomingAppointments = Appointment::with('client')
            ->where('agent_id', $agentId)
            ->whereDate('date_time', '>=', Carbon::today())
            ->orderBy('date_time')
            ->take(3)
            ->get();

        $recentMessages = Message::with('sender')
            ->where('receiver_id', $agentId)
            ->orderBy('timestamp', 'desc')
            ->take(5)
            ->get();

        $recentProperties = Property::with('images')
            ->where('agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return compact('stats', 'upcomingAppointments', 'recentMessages', 'recentProperties');
    }
}
