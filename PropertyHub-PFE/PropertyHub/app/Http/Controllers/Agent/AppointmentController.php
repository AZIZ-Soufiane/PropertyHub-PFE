<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService) {}

    public function index(Request $request)
    {
        $appointments = $this->appointmentService->getAppointmentsForAgent(Auth::id());

        // ── Calendar data ──
        $calMonth = (int) $request->get('month', now()->month);
        $calYear  = (int) $request->get('year', now()->year);
        $calStart = Carbon::create($calYear, $calMonth, 1)->startOfMonth();
        $calEnd   = Carbon::create($calYear, $calMonth, 1)->endOfMonth();

        $appointmentsInMonth = Appointment::with(['client', 'property'])
            ->where('agent_id', Auth::id())
            ->whereBetween('date_time', [$calStart, $calEnd])
            ->get()
            ->groupBy(fn($a) => $a->date_time->format('Y-m-d'));

        $calendar = [
            'year'         => $calYear,
            'month'        => $calMonth,
            'monthName'    => $calStart->format('F'),
            'daysInMonth'  => $calStart->daysInMonth,
            'startDow'     => $calStart->dayOfWeek,
            'prevMonth'    => Carbon::create($calYear, $calMonth, 1)->subMonth(),
            'nextMonth'    => Carbon::create($calYear, $calMonth, 1)->addMonth(),
            'appointments' => $appointmentsInMonth,
        ];

        // ── Selected date details ──
        $calDate = $request->get('cal_date');
        $selectedDateAppts = collect();
        if ($calDate && isset($appointmentsInMonth[$calDate])) {
            $selectedDateAppts = $appointmentsInMonth[$calDate];
        }

        return view('agent.appointments.index', compact('appointments', 'calendar', 'calDate', 'selectedDateAppts'));
    }

    public function show(Appointment $appointment)
    {
        $appointment = $this->appointmentService->findById($appointment->id);
        if ($appointment->agent_id !== Auth::id()) {
            abort(403);
        }
        return view('agent.appointments.show', compact('appointment'));
    }

    public function confirm(Appointment $appointment)
    {
        try {
            $this->appointmentService->confirmAppointment($appointment->id, Auth::id());
            return back()->with('success', 'Appointment confirmed');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Appointment $appointment)
    {
        try {
            $this->appointmentService->cancelAppointment($appointment->id, Auth::id());
            return back()->with('success', 'Appointment cancelled');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
