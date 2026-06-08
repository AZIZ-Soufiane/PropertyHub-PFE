<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService) {}

    public function index()
    {
        $appointments = $this->appointmentService->getAppointmentsForBuyer(Auth::id());
        return view('buyer.appointments.index', compact('appointments'));
    }
}
