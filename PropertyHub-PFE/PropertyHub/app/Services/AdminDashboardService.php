<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Revenue;

class AdminDashboardService
{
    public function __construct(
        private UserService $userService,
        private PropertyService $propertyService,
        private AppointmentService $appointmentService,
    ) {}

    /**
     * Compact stats shape the admin dashboard view expects.
     */
    public function getStats(): array
    {
        $users = $this->userService->getUserStatistics();
        $props = $this->propertyService->getPropertyStatistics();
        $appts = $this->appointmentService->getAppointmentStatistics();

        return [
            'total_users'               => $users['total'],
            'new_users_this_month'      => $users['new_this_month'],
            'total_properties'          => $props['total'],
            'new_properties_this_month' => Property::where('created_at', '>=', now()->startOfMonth())->count(),
            'total_appointments'        => $appts['total'],
            'pending_appointments'      => $appts['pending'],
            'total_revenue'             => (float) Revenue::sum('amount'),
        ];
    }

}
