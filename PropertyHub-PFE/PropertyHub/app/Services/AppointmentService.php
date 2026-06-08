<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    /* -----------------------------------------------------------------
     | Read paths
     | ----------------------------------------------------------------- */

    public function getAppointmentsForAgent(int $agentId, int $perPage = 15): LengthAwarePaginator
    {
        return Appointment::with(['property', 'client'])
            ->where('agent_id', $agentId)
            ->orderBy('date_time', 'desc')
            ->paginate($perPage);
    }

    public function getAppointmentsForBuyer(int $buyerId, int $perPage = 15): LengthAwarePaginator
    {
        return Appointment::with(['property', 'agent'])
            ->where('buyer_id', $buyerId)
            ->orderBy('date_time', 'desc')
            ->paginate($perPage);
    }


    public function getAgentAppointmentsOnDate(int $agentId, Carbon $date): Collection
    {
        return Appointment::with('property', 'client')
            ->where('agent_id', $agentId)
            ->whereDate('date_time', $date)
            ->get();
    }

    public function getUpcomingForAgent(int $agentId, int $limit = 3): Collection
    {
        return Appointment::with(['property', 'client'])
            ->where('agent_id', $agentId)
            ->whereDate('date_time', '>=', Carbon::today())
            ->orderBy('date_time')
            ->take($limit)
            ->get();
    }

    public function findById(int $id): Appointment
    {
        return Appointment::with(['property', 'client'])->findOrFail($id);
    }

    public function getAppointmentStatistics(): array
    {
        return [
            'total'       => Appointment::count(),
            'pending'     => Appointment::where('status', 'pending')->count(),
            'confirmed'   => Appointment::where('status', 'confirmed')->count(),
            'cancelled'   => Appointment::where('status', 'cancelled')->count(),
            'scheduled'   => Appointment::where('status', 'scheduled')->count(),
            'completed'   => Appointment::where('status', 'completed')->count(),
            'today'       => Appointment::whereDate('date_time', Carbon::today())->count(),
        ];
    }

    /**
     * Counts scoped to a single agent.
     */
    public function getAgentStatistics(int $agentId): array
    {
        return [
            'total'              => Appointment::where('agent_id', $agentId)->count(),
            'pending'            => Appointment::where('agent_id', $agentId)->where('status', 'pending')->count(),
            'today'              => Appointment::where('agent_id', $agentId)
                ->where('status', 'pending')
                ->whereDate('date_time', Carbon::today())
                ->count(),
        ];
    }

    /**
     * Backward-compatible paginated getter.
     */
    public function getAllAppointments(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Appointment::with('buyer', 'agent', 'calendar');
        if ($status) {
            $query->where('status', $status);
        }
        return $query->paginate($perPage);
    }

    public function getAvailableSlots(int $agentId, string $date): array
    {
        $agent = User::findOrFail($agentId);
        $calendar = $agent->calendar;

        if (!$calendar) {
            throw new \Exception("Agent does not have a calendar.");
        }

        $slots = [];
        for ($hour = 9; $hour < 18; $hour++) {
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

    /* -----------------------------------------------------------------
     | Write paths
     | ----------------------------------------------------------------- */

    public function bookAppointment(int $buyerId, int $agentId, int|string|null $propertyIdOrDateTime = null, ?string $dateTime = null): Appointment
    {
        if ($dateTime === null) {
            $dateTime = (string) $propertyIdOrDateTime;
            $propertyId = null;
        } else {
            $propertyId = (int) $propertyIdOrDateTime;
        }

        return DB::transaction(function () use ($buyerId, $agentId, $propertyId, $dateTime) {
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
                'date_time'   => $appointmentDateTime,
                'status'      => 'scheduled',
                'buyer_id'    => $buyerId,
                'agent_id'    => $agentId,
                'property_id' => $propertyId,
                'calendar_id' => $calendar->id,
            ]);
        });
    }

    public function confirmAppointment(int $appointmentId, int $agentId): Appointment
    {
        return DB::transaction(function () use ($appointmentId, $agentId) {
            $appointment = Appointment::findOrFail($appointmentId);
            if ($appointment->agent_id !== $agentId) {
                throw new \Exception("Unauthorized action.");
            }
            $appointment->update(['status' => 'confirmed']);
            return $appointment;
        });
    }

    public function cancelAppointment(int $appointmentId, ?int $userId = null): void
    {
        DB::transaction(function () use ($appointmentId, $userId) {
            $appointment = Appointment::findOrFail($appointmentId);

            if ($userId && $appointment->buyer_id !== $userId && $appointment->agent_id !== $userId) {
                throw new \Exception("Unauthorized action.");
            }

            $appointment->update(['status' => 'cancelled']);
        });
    }
}
