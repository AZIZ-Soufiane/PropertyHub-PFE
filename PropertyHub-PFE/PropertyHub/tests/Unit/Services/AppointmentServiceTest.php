<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Calendar;
use App\Services\AppointmentService;

class AppointmentServiceTest extends TestCase
{
    protected AppointmentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AppointmentService();
    }

    /**
     * @group mvp
     */
    public function test_get_available_slots_using_real_db()
    {
        $agent = User::where('role', 'agent')->first();
        if (!$agent) {
            $this->markTestSkipped('Agent missing');
        }

        // Ensure agent has a calendar
        $calendar = Calendar::firstOrCreate(['agent_id' => $agent->id]);

        $slots = $this->service->getAvailableSlots($agent->id, '2026-05-01');

        $this->assertIsArray($slots);
        // Business hours 9-18 = 9 slots
        $this->assertGreaterThanOrEqual(1, count($slots));
    }

    /**
     * @group mvp
     */
    public function test_book_appointment_using_real_db()
    {
        $buyer = User::where('role', 'buyer')->first();
        $agent = User::where('role', 'agent')->first();

        if (!$buyer || !$agent) {
             $this->markTestSkipped('Buyer or Agent missing');
        }

        // Re-ensure calendar
        Calendar::firstOrCreate(['agent_id' => $agent->id]);

        $dateTime = '2026-05-01 10:00:00';
        $appointment = $this->service->bookAppointment($buyer->id, $agent->id, $dateTime);

        $this->assertEquals($buyer->id, $appointment->buyer_id);
        $this->assertEquals($agent->id, $appointment->agent_id);
        $this->assertEquals('scheduled', $appointment->status);

        // Cleanup
        $appointment->delete();
    }

    /**
     * @group mvp
     */
    public function test_cancel_appointment_using_real_db()
    {
        $buyer = User::where('role', 'buyer')->first();
        $agent = User::where('role', 'agent')->first();
        Calendar::firstOrCreate(['agent_id' => $agent->id]);

        $apt = $this->service->bookAppointment($buyer->id, $agent->id, '2026-05-01 11:00:00');
        
        $this->service->cancelAppointment($apt->id, $buyer->id);

        $updated = Appointment::find($apt->id);
        $this->assertEquals('cancelled', $updated->status);

        // Cleanup
        $apt->delete();
    }
}
