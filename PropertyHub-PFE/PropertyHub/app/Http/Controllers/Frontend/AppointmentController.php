<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private PropertyService $propertyService,
    ) {}

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to schedule an appointment.');
        }

        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'date'        => 'required|date|after_or_equal:today',
            'time_slot'   => 'required',
        ]);

        try {
            $property  = $this->propertyService->getPropertyById((int) $validated['property_id']);
            $agentId   = $property->agent_id;
            $dateTime  = $validated['date'] . ' ' . $validated['time_slot'];

            if (!$agentId) {
                return back()->with('error', 'This property does not have an assigned agent.');
            }

            $this->appointmentService->bookAppointment(Auth::id(), $agentId, $property->id, $dateTime);
            return back()->with('success', 'Appointment scheduled successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
