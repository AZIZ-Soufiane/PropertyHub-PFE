<?php

namespace Tests\Unit\Services\Public;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use App\Services\Public\AppointmentService;

class AppointmentServiceTest extends TestCase
{
    protected AppointmentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AppointmentService();
    }

    public function test_get_available_slots()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        Calendar::factory()->create(['agent_id' => $agent->id]);

        $slots = $this->service->getAvailableSlots($agent->id, date('Y-m-d'));

        $this->assertIsArray($slots);
        $this->assertGreaterThan(0, count($slots));
    }

    public function test_book_appointment()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        Calendar::factory()->create(['agent_id' => $agent->id]);

        $dateTime = now()->addDay()->format('Y-m-d 10:00');
        $appointment = $this->service->bookAppointment($buyer->id, $agent->id, $dateTime);

        $this->assertEquals($buyer->id, $appointment->buyer_id);
        $this->assertEquals($agent->id, $appointment->agent_id);
        $this->assertEquals('scheduled', $appointment->status);
    }

    public function test_book_appointment_throws_exception_for_no_calendar()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Agent does not have a calendar.");

        $this->service->bookAppointment($buyer->id, $agent->id, now()->format('Y-m-d 10:00'));
    }

    public function test_book_appointment_throws_exception_for_booked_slot()
    {
        $buyer1 = User::factory()->create(['role' => 'buyer']);
        $buyer2 = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        $dateTime = now()->addDay()->format('Y-m-d 10:00');

        $this->service->bookAppointment($buyer1->id, $agent->id, $dateTime);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("This time slot is already booked.");

        $this->service->bookAppointment($buyer2->id, $agent->id, $dateTime);
    }

    public function test_cancel_appointment()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        $appointment = Appointment::factory()->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
            'status' => 'scheduled',
        ]);

        $this->service->cancelAppointment($appointment->id, $buyer->id);

        $this->assertEquals('cancelled', $appointment->fresh()->status);
    }

    public function test_cancel_appointment_throws_exception_for_unauthorized()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);
        $unauthorized_user = User::factory()->create();

        $appointment = Appointment::factory()->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
        ]);

        $this->expectException(\Exception::class);
        $this->service->cancelAppointment($appointment->id, $unauthorized_user->id);
    }

    public function test_reschedule_appointment()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        $appointment = Appointment::factory()->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
        ]);

        $newDateTime = now()->addDays(2)->format('Y-m-d 14:00');
        $rescheduled = $this->service->rescheduleAppointment($appointment->id, $newDateTime, $buyer->id);

        $this->assertNotEquals($appointment->date_time, $rescheduled->date_time);
    }

    public function test_get_user_appointments()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        Appointment::factory()->count(3)->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
        ]);

        $result = $this->service->getUserAppointments($buyer->id);

        $this->assertCount(3, $result->items());
    }

    public function test_get_appointment_details()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        $appointment = Appointment::factory()->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
        ]);

        $result = $this->service->getAppointmentDetails($appointment->id);

        $this->assertEquals($appointment->id, $result->id);
    }

    public function test_complete_appointment()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        $appointment = Appointment::factory()->create([
            'buyer_id' => $buyer->id,
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
            'status' => 'scheduled',
        ]);

        $completed = $this->service->completeAppointment($appointment->id);

        $this->assertEquals('completed', $completed->status);
    }
}
