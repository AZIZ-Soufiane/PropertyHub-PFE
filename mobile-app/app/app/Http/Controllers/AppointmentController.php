<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Demo appointments data
     */
    private function getAgents()
    {
        return [
            ['id' => 1, 'name' => 'John Smith', 'phone' => '+1 (555) 123-4567', 'email' => 'john@propertyagent.com'],
            ['id' => 2, 'name' => 'Sarah Johnson', 'phone' => '+1 (555) 234-5678', 'email' => 'sarah@propertyagent.com'],
            ['id' => 3, 'name' => 'Michael Brown', 'phone' => '+1 (555) 345-6789', 'email' => 'michael@propertyagent.com'],
            ['id' => 4, 'name' => 'Emily Davis', 'phone' => '+1 (555) 456-7890', 'email' => 'emily@propertyagent.com'],
            ['id' => 5, 'name' => 'David Wilson', 'phone' => '+1 (555) 567-8901', 'email' => 'david@propertyagent.com'],
        ];
    }

    private function getDemoAppointments()
    {
        return [
            [
                'id' => 1,
                'property' => 'Modern Luxury Villa',
                'location' => 'New York, USA',
                'date' => '2024-02-15',
                'time' => '10:00 AM',
                'agent' => ['id' => 1, 'name' => 'John Smith', 'phone' => '+1 (555) 123-4567'],
                'status' => 'Confirmed',
            ],
            [
                'id' => 2,
                'property' => 'Contemporary Apartment',
                'location' => 'Los Angeles, USA',
                'date' => '2024-02-18',
                'time' => '2:00 PM',
                'agent' => ['id' => 2, 'name' => 'Sarah Johnson', 'phone' => '+1 (555) 234-5678'],
                'status' => 'Pending',
            ],
            [
                'id' => 3,
                'property' => 'Penthouse Downtown',
                'location' => 'Miami, USA',
                'date' => '2024-02-20',
                'time' => '3:30 PM',
                'agent' => ['id' => 4, 'name' => 'Emily Davis', 'phone' => '+1 (555) 456-7890'],
                'status' => 'Confirmed',
            ],
        ];
    }

    /**
     * Show appointments - public demo view
     */
    public function index()
    {
        // Get stored appointments from session or use demo appointments
        $appointments = session('user_appointments', $this->getDemoAppointments());

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show booking form - public demo without requiring agent ID
     */
    public function book(Request $request)
    {
        $propertyId = $request->get('property_id');
        $agents = $this->getAgents();

        return view('appointments.book', compact('agents', 'propertyId'));
    }

    /**
     * Get available slots for an agent and date - demo slots
     */
    public function getSlots(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        // Return demo time slots
        $slots = [
            '09:00' => '9:00 AM',
            '10:00' => '10:00 AM',
            '12:00' => '12:00 PM',
            '14:00' => '2:00 PM',
            '15:00' => '3:00 PM',
            '17:00' => '5:00 PM',
        ];

        return response()->json(['success' => true, 'slots' => $slots]);
    }

    /**
     * Store appointment - save to session
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'message' => 'nullable|string',
        ]);

        // Create appointment object
        $appointment = [
            'id' => date('Ymdhis'),
            'property' => 'Property Viewing',
            'location' => 'TBD',
            'date' => $request->date,
            'time' => $request->time,
            'agent' => ['name' => 'Agent TBD', 'phone' => $request->phone],
            'status' => 'Pending',
            'client_name' => $request->name,
            'client_email' => $request->email,
            'client_phone' => $request->phone,
            'client_message' => $request->message,
        ];

        // Store in session
        $appointments = session('user_appointments', $this->getDemoAppointments());
        $appointments[] = $appointment;
        session(['user_appointments' => $appointments]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment requested successfully! We will contact you soon.');
    }

    /**
     * Cancel appointment - remove from session
     */
    public function cancel($appointmentId)
    {
        $appointments = session('user_appointments', $this->getDemoAppointments());
        $appointments = collect($appointments)
            ->reject(fn($a) => $a['id'] == $appointmentId)
            ->values()
            ->all();

        session(['user_appointments' => $appointments]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Reschedule appointment - update session
     */
    public function reschedule(Request $request, $appointmentId)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        $appointments = session('user_appointments', $this->getDemoAppointments());

        foreach ($appointments as &$appt) {
            if ($appt['id'] == $appointmentId) {
                $appt['date'] = $request->date;
                $appt['time'] = $request->time;
                break;
            }
        }

        session(['user_appointments' => $appointments]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment rescheduled successfully.');
    }
}
