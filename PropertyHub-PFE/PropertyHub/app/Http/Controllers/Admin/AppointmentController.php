<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Property;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService) {}

    /**
     * Only appointments for properties listed by this admin.
     */
    private function adminPropertyIds(): array
    {
        return Property::where('agent_id', Auth::id())->pluck('id')->toArray();
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $propertyIds = $this->adminPropertyIds();

        $appointments = Appointment::with(['property', 'client', 'agent'])
            ->whereIn('property_id', $propertyIds)
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('date_time', 'desc')
            ->paginate(15);

        // Scoped stats for admin's own properties
        $stats = [
            'total'     => Appointment::whereIn('property_id', $propertyIds)->count(),
            'pending'   => Appointment::whereIn('property_id', $propertyIds)->where('status', 'pending')->count(),
            'confirmed' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'confirmed')->count(),
            'completed' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'completed')->count(),
            'cancelled' => Appointment::whereIn('property_id', $propertyIds)->where('status', 'cancelled')->count(),
            'today'     => Appointment::whereIn('property_id', $propertyIds)->whereDate('date_time', today())->count(),
        ];

        // ── Calendar data ──
        $calMonth = (int) $request->get('month', now()->month);
        $calYear  = (int) $request->get('year', now()->year);
        $calStart = Carbon::create($calYear, $calMonth, 1)->startOfMonth();
        $calEnd   = Carbon::create($calYear, $calMonth, 1)->endOfMonth();

        $appointmentsInMonth = Appointment::with(['client', 'property', 'agent'])
            ->whereIn('property_id', $propertyIds)
            ->whereBetween('date_time', [$calStart, $calEnd])
            ->get()
            ->groupBy(fn($a) => $a->date_time->format('Y-m-d'));

        $calendar = [
            'year'        => $calYear,
            'month'       => $calMonth,
            'monthName'   => $calStart->format('F'),
            'daysInMonth' => $calStart->daysInMonth,
            'startDow'    => $calStart->dayOfWeek, // 0=Sun, 6=Sat
            'prevMonth'   => Carbon::create($calYear, $calMonth, 1)->subMonth(),
            'nextMonth'   => Carbon::create($calYear, $calMonth, 1)->addMonth(),
            'appointments' => $appointmentsInMonth,
        ];

        // ── Selected date details ──
        $calDate = $request->get('cal_date');
        $selectedDateAppts = collect();
        if ($calDate && isset($appointmentsInMonth[$calDate])) {
            $selectedDateAppts = $appointmentsInMonth[$calDate];
        }

        return view('admin.appointments.index', compact('appointments', 'stats', 'status', 'calendar', 'calDate', 'selectedDateAppts'));
    }

    public function show(Appointment $appointment)
    {
        // Ensure admin owns this property
        abort_unless(in_array($appointment->property_id, $this->adminPropertyIds()), 403);

        $appointment->load(['property', 'client', 'agent']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function confirm(Appointment $appointment)
    {
        abort_unless(in_array($appointment->property_id, $this->adminPropertyIds()), 403);
        $appointment->update(['status' => 'confirmed']);
        return back()->with('success', 'Appointment confirmed.');
    }

    public function cancel(Appointment $appointment)
    {
        abort_unless(in_array($appointment->property_id, $this->adminPropertyIds()), 403);
        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment cancelled.');
    }

    public function complete(Appointment $appointment)
    {
        abort_unless(in_array($appointment->property_id, $this->adminPropertyIds()), 403);
        $appointment->update(['status' => 'completed']);
        return back()->with('success', 'Appointment marked as completed.');
    }
}
