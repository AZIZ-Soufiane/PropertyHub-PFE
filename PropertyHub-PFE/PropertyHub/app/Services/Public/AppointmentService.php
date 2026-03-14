<?php

namespace App\Services\Public;

use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentService
{
    /**
     * Get available time slots for an agent's calendar.
     * 
     * @param int $agentId
     * @param string $date
     * @return array
     */
    public function getAvailableSlots(int $agentId, string $date): array
    {
        $agent = User::findOrFail($agentId);
        $calendar = $agent->calendar;

        if (!$calendar) {
            throw new \Exception("Agent does not have a calendar.");
        }

        // Assuming business hours: 9 AM to 6 PM, 1-hour slots
        $slots = [];
        $startHour = 9;
        $endHour = 18;

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $slotTime = Carbon::createFromFormat('Y-m-d H:i', "$date $hour:00");
            
            $isBooked = Appointment::where('calendar_id', $calendar->id)
                ->where('date_time', $slotTime)
                ->exists();

            if (!$isBooked) {
                $slots[] = $slotTime->format('H:i');
            }
        }

        return $slots;
    }

    /**
     * Book an appointment for a buyer.
     * 
     * @param int $buyerId
     * @param int $agentId
     * @param string $dateTime
     * @return Appointment
     */
    public function bookAppointment(int $buyerId, int $agentId, string $dateTime): Appointment
    {
        return DB::transaction(function () use ($buyerId, $agentId, $dateTime) {
            $buyer = User::findOrFail($buyerId);
            $agent = User::findOrFail($agentId);
            $calendar = $agent->calendar;

            if (!$calendar) {
                throw new \Exception("Agent does not have a calendar.");
            }

            $appointmentDateTime = Carbon::parse($dateTime);

            // Check if slot is already booked
            $exists = Appointment::where('calendar_id', $calendar->id)
                ->where('date_time', $appointmentDateTime)
                ->exists();

            if ($exists) {
                throw new \Exception("This time slot is already booked.");
            }

            return Appointment::create([
                'date_time' => $appointmentDateTime,
                'status' => 'scheduled',
                'buyer_id' => $buyerId,
                'agent_id' => $agentId,
                'calendar_id' => $calendar->id,
            ]);
        });
    }

    /**
     * Cancel an appointment.
     * 
     * @param int $appointmentId
     * @param int $userId
     * @return void
     */
    public function cancelAppointment(int $appointmentId, int $userId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Only buyer or agent can cancel
        if ($appointment->buyer_id !== $userId && $appointment->agent_id !== $userId) {
            throw new \Exception("Unauthorized action.");
        }

        $appointment->update(['status' => 'cancelled']);
    }

    /**
     * Reschedule an appointment.
     * 
     * @param int $appointmentId
     * @param string $newDateTime
     * @param int $userId
     * @return Appointment
     */
    public function rescheduleAppointment(int $appointmentId, string $newDateTime, int $userId): Appointment
    {
        return DB::transaction(function () use ($appointmentId, $newDateTime, $userId) {
            $appointment = Appointment::findOrFail($appointmentId);

            // Only buyer or agent can reschedule
            if ($appointment->buyer_id !== $userId && $appointment->agent_id !== $userId) {
                throw new \Exception("Unauthorized action.");
            }

            $newTime = Carbon::parse($newDateTime);

            // Check if new slot is available
            $exists = Appointment::where('calendar_id', $appointment->calendar_id)
                ->where('date_time', $newTime)
                ->where('id', '!=', $appointmentId)
                ->exists();

            if ($exists) {
                throw new \Exception("This time slot is already booked.");
            }

            $appointment->update(['date_time' => $newTime]);
            return $appointment;
        });
    }

    /**
     * Get user's appointments with status filtering.
     * 
     * @param int $userId
     * @param string|null $status
     * @param int $perPage
     * @return mixed
     */
    public function getUserAppointments(int $userId, string $status = null, int $perPage = 15)
    {
        $query = Appointment::where('buyer_id', $userId)
            ->orWhere('agent_id', $userId)
            ->with('buyer', 'agent', 'calendar');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate($perPage);
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
     * Complete an appointment.
     * 
     * @param int $appointmentId
     * @return Appointment
     */
    public function completeAppointment(int $appointmentId): Appointment
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update(['status' => 'completed']);
        return $appointment;
    }
}
