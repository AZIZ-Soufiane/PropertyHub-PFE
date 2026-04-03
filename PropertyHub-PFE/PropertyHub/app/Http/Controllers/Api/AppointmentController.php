<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentService $appointmentService)
    {
    }

    /**
     * Get all appointments for the authenticated user
     */
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->id();
        $status = $request->get('status');
        $perPage = $request->get('per_page', 15);

        $query = \App\Models\Appointment::where(function ($q) use ($userId) {
            $q->where('buyer_id', $userId)
              ->orWhere('agent_id', $userId);
        });

        if ($status) {
            $query->where('status', $status);
        }

        $appointments = $query->with('buyer', 'agent', 'calendar')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => AppointmentResource::collection($appointments),
            'meta' => [
                'current_page' => $appointments->currentPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
                'last_page' => $appointments->lastPage(),
            ]
        ]);
    }

    /**
     * Get appointment by ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $appointment = \App\Models\Appointment::with('buyer', 'agent', 'calendar')->findOrFail($id);
            
            return response()->json([
                'status' => 'success',
                'data' => new AppointmentResource($appointment),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Appointment not found',
            ], 404);
        }
    }

    /**
     * Get available slots for an agent on a specific date
     */
    public function getAvailableSlots(int $agentId, Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        try {
            $slots = $this->appointmentService->getAvailableSlots($agentId, $request->get('date'));

            return response()->json([
                'status' => 'success',
                'data' => $slots,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Book an appointment
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
            'date_time' => 'required|date_format:Y-m-d H:i',
        ]);

        try {
            $buyerId = auth()->id();
            $appointment = $this->appointmentService->bookAppointment(
                $buyerId,
                $request->get('agent_id'),
                $request->get('date_time')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Appointment booked successfully',
                'data' => new AppointmentResource($appointment),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Cancel an appointment
     */
    public function cancel(int $appointmentId): JsonResponse
    {
        try {
            $userId = auth()->id();
            $this->appointmentService->cancelAppointment($appointmentId, $userId);

            return response()->json([
                'status' => 'success',
                'message' => 'Appointment cancelled successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Reschedule an appointment
     */
    public function reschedule(int $appointmentId, Request $request): JsonResponse
    {
        $request->validate([
            'date_time' => 'required|date_format:Y-m-d H:i',
        ]);

        try {
            $userId = auth()->id();
            $this->appointmentService->rescheduleAppointment($appointmentId, $request->get('date_time'), $userId);

            $appointment = \App\Models\Appointment::with('buyer', 'agent', 'calendar')->findOrFail($appointmentId);

            return response()->json([
                'status' => 'success',
                'message' => 'Appointment rescheduled successfully',
                'data' => new AppointmentResource($appointment),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Mark appointment as complete
     */
    public function complete(int $appointmentId): JsonResponse
    {
        try {
            $this->appointmentService->completeAppointment($appointmentId);

            $appointment = \App\Models\Appointment::with('buyer', 'agent', 'calendar')->findOrFail($appointmentId);

            return response()->json([
                'status' => 'success',
                'message' => 'Appointment marked as complete',
                'data' => new AppointmentResource($appointment),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete an appointment
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            \App\Models\Appointment::findOrFail($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Appointment deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
