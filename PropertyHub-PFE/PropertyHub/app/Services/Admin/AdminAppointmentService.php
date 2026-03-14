<?php

namespace App\Services\Admin;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminAppointmentService
{
    /**
     * Get all appointments with pagination.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllAppointments(int $perPage = 15)
    {
        return Appointment::with('buyer', 'agent', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get appointments by status.
     * 
     * @param string $status
     * @param int $perPage
     * @return mixed
     */
    public function getAppointmentsByStatus(string $status, int $perPage = 15)
    {
        return Appointment::where('status', $status)
            ->with('buyer', 'agent', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get all appointments for a specific agent.
     * 
     * @param int $agentId
     * @param int $perPage
     * @return mixed
     */
    public function getAgentAppointments(int $agentId, int $perPage = 15)
    {
        User::findOrFail($agentId); // Verify agent exists

        return Appointment::where('agent_id', $agentId)
            ->with('buyer', 'agent', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get all appointments for a specific buyer.
     * 
     * @param int $buyerId
     * @param int $perPage
     * @return mixed
     */
    public function getBuyerAppointments(int $buyerId, int $perPage = 15)
    {
        User::findOrFail($buyerId); // Verify buyer exists

        return Appointment::where('buyer_id', $buyerId)
            ->with('buyer', 'agent', 'calendar')
            ->paginate($perPage);
    }

    /**
     * Get appointment details.
     * 
     * @param int $appointmentId
     * @return Appointment
     */
    public function getAppointmentDetails(int $appointmentId): Appointment
    {
        return Appointment::with('buyer', 'agent', 'calendar')
            ->findOrFail($appointmentId);
    }

    /**
     * Update appointment status.
     * 
     * @param int $appointmentId
     * @param string $status
     * @return Appointment
     */
    public function updateAppointmentStatus(int $appointmentId, string $status): Appointment
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $validStatuses = ['scheduled', 'completed', 'cancelled', 'no-show'];
        if (!in_array($status, $validStatuses)) {
            throw new \Exception("Invalid status: " . $status);
        }

        $appointment->update(['status' => $status]);
        return $appointment;
    }

    /**
     * Cancel multiple appointments.
     * 
     * @param array $appointmentIds
     * @return int
     */
    public function cancelAppointments(array $appointmentIds): int
    {
        return Appointment::whereIn('id', $appointmentIds)
            ->update(['status' => 'cancelled']);
    }

    /**
     * Get appointment statistics.
     * 
     * @return array
     */
    public function getAppointmentStatistics(): array
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
     * Get appointments in a date range.
     * 
     * @param string $startDate
     * @param string $endDate
     * @param int $perPage
     * @return mixed
     */
    public function getAppointmentsByDateRange(string $startDate, string $endDate, int $perPage = 15)
    {
        return Appointment::whereBetween('date_time', [$startDate, $endDate])
            ->with('buyer', 'agent', 'calendar')
            ->orderBy('date_time', 'asc')
            ->paginate($perPage);
    }

    /**
     * Delete an appointment.
     * 
     * @param int $appointmentId
     * @return void
     */
    public function deleteAppointment(int $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->delete();
    }

    /**
     * Get today's appointments.
     * 
     * @return mixed
     */
    public function getTodayAppointments()
    {
        $today = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        return Appointment::whereBetween('date_time', [$today, $todayEnd])
            ->with('buyer', 'agent', 'calendar')
            ->orderBy('date_time', 'asc')
            ->get();
    }
}
