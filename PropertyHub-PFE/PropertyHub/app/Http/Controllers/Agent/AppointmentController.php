<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService) {}

    public function index()
    {
        $appointments = $this->appointmentService->getAppointmentsForAgent(Auth::id());
        return view('agent.appointments.index', compact('appointments'));
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
