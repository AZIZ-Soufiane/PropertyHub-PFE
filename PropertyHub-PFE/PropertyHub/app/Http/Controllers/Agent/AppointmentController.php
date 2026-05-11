<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['property', 'client'])
            ->whereHas('property', fn($q) => $q->where('agent_id', Auth::id()))
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);
            
        return view('agent.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        if ($appointment->property->agent_id !== Auth::id()) {
            abort(403);
        }
        
        $appointment->load(['property', 'client']);
        
        return view('agent.appointments.show', compact('appointment'));
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->property->agent_id !== Auth::id()) {
            abort(403);
        }
        
        $appointment->update(['status' => 'confirmed']);
        
        return back()->with('success', 'Appointment confirmed');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->property->agent_id !== Auth::id()) {
            abort(403);
        }
        
        $appointment->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Appointment cancelled');
    }
}