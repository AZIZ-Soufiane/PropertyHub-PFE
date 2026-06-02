<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Property;
use Carbon\Carbon;

class AgentDashboardService
{
    public function __construct(
        private PropertyService $propertyService,
        private AppointmentService $appointmentService,
        private MessageService $messageService,
    ) {}

    /**
     * Build the full data set for the agent landing page.
     */
    public function getDashboardData(int $agentId): array
    {
        $propertyStats    = $this->propertyService->getAgentStatistics($agentId);
        $appointmentStats = $this->appointmentService->getAgentStatistics($agentId);

        $stats = [
            'active_listings'    => $propertyStats['approved'],
            'pending_viewings'   => $appointmentStats['today'],
            'total_appointments' => $appointmentStats['total'],
            'unread_messages'    => $this->messageService->getUnreadCount($agentId),
            'new_this_week'      => $propertyStats['new_this_week'],
        ];

        $upcomingAppointments = $this->appointmentService->getUpcomingForAgent($agentId, 3);

        $recentMessages = Message::with('sender')
            ->where('receiver_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentProperties = Property::with('images')
            ->where('agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return [
            'stats'                => $stats,
            'upcomingAppointments' => $upcomingAppointments,
            'recentMessages'       => $recentMessages,
            'recentProperties'     => $recentProperties,
        ];
    }
}
