<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService)
    {
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to schedule an appointment.');
        }

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required',
        ]);

        $property = Property::findOrFail($request->property_id);
        $agentId = $property->agent_id;

        if (!$agentId) {
            return redirect()->back()->with('error', 'This property does not have an assigned agent.');
        }

        $dateTime = $request->date . ' ' . $request->time_slot;

        try {
            $this->appointmentService->bookAppointment(Auth::id(), $agentId, $dateTime);

            return redirect()->back()->with('success', 'Appointment scheduled successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}