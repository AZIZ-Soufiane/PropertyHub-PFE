<?php

namespace App\Services\Admin;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminCalendarService
{
    /**
     * Get all calendars with pagination.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllCalendars(int $perPage = 15)
    {
        return Calendar::with('agent', 'appointments')->paginate($perPage);
    }

    /**
     * Get calendar for a specific agent.
     * 
     * @param int $agentId
     * @return Calendar
     */
    public function getAgentCalendar(int $agentId): Calendar
    {
        $agent = User::findOrFail($agentId);

        $calendar = $agent->calendar;
        if (!$calendar) {
            throw new \Exception("Agent does not have a calendar.");
        }

        return $calendar->load('appointments', 'agent');
    }

    /**
     * Create a calendar for an agent.
     * 
     * @param int $agentId
     * @return Calendar
     */
    public function createCalendarForAgent(int $agentId): Calendar
    {
        return DB::transaction(function () use ($agentId) {
            $agent = User::findOrFail($agentId);

            // Check if agent already has a calendar
            if ($agent->calendar) {
                throw new \Exception("Agent already has a calendar.");
            }

            // Verify user is an agent
            if ($agent->role !== 'agent') {
                throw new \Exception("Can only create calendar for agents.");
            }

            return Calendar::create([
                'agent_id' => $agentId,
            ]);
        });
    }

    /**
     * Delete a calendar.
     * Rule: Prevent deletion if calendar has appointments.
     * 
     * @param int $calendarId
     * @return void
     */
    public function deleteCalendar(int $calendarId): void
    {
        DB::transaction(function () use ($calendarId) {
            $calendar = Calendar::findOrFail($calendarId);

            // Check if calendar has appointments
            if ($calendar->appointments()->count() > 0) {
                throw new \Exception("Cannot delete calendar with existing appointments.");
            }

            $calendar->delete();
        });
    }

    /**
     * Get calendar with appointments.
     * 
     * @param int $calendarId
     * @return Calendar
     */
    public function getCalendarWithAppointments(int $calendarId): Calendar
    {
        return Calendar::with('agent', 'appointments')
            ->findOrFail($calendarId);
    }

    /**
     * Get appointments for a calendar in date range.
     * 
     * @param int $calendarId
     * @param string $startDate
     * @param string $endDate
     * @return mixed
     */
    public function getCalendarAppointmentsByDateRange(int $calendarId, string $startDate, string $endDate)
    {
        return Calendar::findOrFail($calendarId)
            ->appointments()
            ->whereBetween('date_time', [$startDate, $endDate])
            ->with('buyer', 'agent')
            ->orderBy('date_time', 'asc')
            ->get();
    }

    /**
     * Get calendar details.
     * 
     * @param int $calendarId
     * @return Calendar
     */
    public function getCalendarDetails(int $calendarId): Calendar
    {
        return Calendar::with('agent', 'appointments')
            ->findOrFail($calendarId);
    }

    /**
     * Get calendar statistics.
     * 
     * @return array
     */
    public function getCalendarStatistics(): array
    {
        return [
            'total_calendars' => Calendar::count(),
            'agents_with_calendar' => Calendar::distinct('agent_id')->count('agent_id'),
        ];
    }

    /**
     * Check if agent has calendar.
     * 
     * @param int $agentId
     * @return bool
     */
    public function agentHasCalendar(int $agentId): bool
    {
        return Calendar::where('agent_id', $agentId)->exists();
    }
}
