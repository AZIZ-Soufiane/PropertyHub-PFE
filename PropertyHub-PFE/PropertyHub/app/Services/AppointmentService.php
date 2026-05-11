<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    /**
     * Get available time slots for an agent's calendar.
     */
    public function getAvailableSlots(int $agentId, string $date): array
    {
        $agent = User::findOrFail($agentId);
        $calendar = $agent->calendar;

        if (!$calendar) {
            throw new \Exception("Agent does not have a calendar.");
        }

        $slots = [];
        $startHour = 9;
        $endHour = 18;

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $slotTime = Carbon::createFromFormat('Y-m-d H:i', "$date $hour:00");
            
            $isBooked = Appointment::where('calendar_id', $calendar->id)
                ->where('date_time', $slotTime)
                ->where('status', '!=', 'cancelled')
                ->exists();

            if (!$isBooked) {
                $slots[] = $slotTime->format('H:i');
            }
        }

        return $slots;
    }

    /**
     * Book an appointment.
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

            $exists = Appointment::where('calendar_id', $calendar->id)
                ->where('date_time', $appointmentDateTime)
                ->where('status', '!=', 'cancelled')
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

    /* Additional Admin specific methods for global overview */
    public function getAllAppointments(string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Appointment::with('buyer', 'agent', 'calendar');
        if ($status) {
            $query->where('status', $status);
        }
        return $query->paginate($perPage);
    }

    /**
     * Cancelation.
     */
    public function cancelAppointment(int $appointmentId, int $userId = null): void
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // If userId is provided, ensure they have rights to cancel
        if ($userId && $appointment->buyer_id !== $userId && $appointment->agent_id !== $userId) {
            throw new \Exception("Unauthorized action.");
        }

        $appointment->update(['status' => 'cancelled']);
    }

    public function getAppointmentStatistics(): array
    {
        return [
            'total' => Appointment::count(),
            'scheduled' => Appointment::where('status', 'scheduled')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
    }
}
