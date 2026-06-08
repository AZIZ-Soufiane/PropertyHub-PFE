<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private MessageService $messageService
    ) {}

    public function index()
    {
        $userId = Auth::id();

        $appointments = $this->appointmentService->getAppointmentsForBuyer($userId, 10);
        $recentMessages = $this->messageService->getRecentConversations($userId, 'buyer', 5);

        $user = Auth::user();
        $stats = [
            'total'     => $appointments->total(),
            'pending'   => $appointments->getCollection()->where('status', 'pending')->count(),
            'confirmed' => $appointments->getCollection()->where('status', 'confirmed')->count(),
            'cancelled' => $appointments->getCollection()->where('status', 'cancelled')->count(),
            'favorites' => $user->favorites()->count(),
        ];

        return view('buyer.dashboard', compact('appointments', 'recentMessages', 'stats'));
    }
}
