<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use App\Services\Admin\AdminAppointmentService;

class AdminAppointmentServiceTest extends TestCase
{
    protected AdminAppointmentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminAppointmentService();
    }

    public function test_get_all_appointments()
    {
        Appointment::factory()->count(5)->create();

        $result = $this->service->getAllAppointments(15);

        $this->assertCount(5, $result->items());
    }

    public function test_get_appointments_by_status()
    {
        Appointment::factory()->count(3)->create(['status' => 'scheduled']);
        Appointment::factory()->count(2)->create(['status' => 'completed']);

        $result = $this->service->getAppointmentsByStatus('scheduled');

        $this->assertCount(3, $result->items());
    }

    public function test_get_agent_appointments()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $calendar = Calendar::factory()->create(['agent_id' => $agent->id]);

        Appointment::factory()->count(3)->create([
            'agent_id' => $agent->id,
            'calendar_id' => $calendar->id,
        ]);

        $result = $this->service->getAgentAppointments($agent->id);

        $this->assertCount(3, $result->items());
    }

    public function test_get_buyer_appointments()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        Appointment::factory()->count(3)->create(['buyer_id' => $buyer->id]);

        $result = $this->service->getBuyerAppointments($buyer->id);

        $this->assertCount(3, $result->items());
    }

    public function test_get_appointment_details()
    {
        $appointment = Appointment::factory()->create();

        $result = $this->service->getAppointmentDetails($appointment->id);

        $this->assertEquals($appointment->id, $result->id);
    }

    public function test_update_appointment_status()
    {
        $appointment = Appointment::factory()->create(['status' => 'scheduled']);

        $updated = $this->service->updateAppointmentStatus($appointment->id, 'completed');

        $this->assertEquals('completed', $updated->status);
    }

    public function test_update_appointment_status_throws_exception_for_invalid_status()
    {
        $appointment = Appointment::factory()->create();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid status");

        $this->service->updateAppointmentStatus($appointment->id, 'invalid');
    }

    public function test_cancel_appointments()
    {
        Appointment::factory()->count(3)->create(['status' => 'scheduled']);

        $result = $this->service->cancelAppointments(
            Appointment::pluck('id')->toArray()
        );

        $this->assertEquals(3, $result);
        $this->assertEquals(3, Appointment::where('status', 'cancelled')->count());
    }

    public function test_get_appointment_statistics()
    {
        Appointment::factory()->count(5)->create(['status' => 'scheduled']);
        Appointment::factory()->count(2)->create(['status' => 'completed']);
        Appointment::factory()->count(1)->create(['status' => 'cancelled']);

        $stats = $this->service->getAppointmentStatistics();

        $this->assertEquals(8, $stats['total']);
        $this->assertEquals(5, $stats['scheduled']);
        $this->assertEquals(2, $stats['completed']);
        $this->assertEquals(1, $stats['cancelled']);
    }

    public function test_get_appointments_by_date_range()
    {
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(7)->format('Y-m-d');

        Appointment::factory()->count(3)->create([
            'date_time' => now()->addDays(2),
        ]);

        $result = $this->service->getAppointmentsByDateRange($startDate, $endDate);

        $this->assertCount(3, $result->items());
    }

    public function test_delete_appointment()
    {
        $appointment = Appointment::factory()->create();

        $this->service->deleteAppointment($appointment->id);

        $this->assertNull(Appointment::find($appointment->id));
    }

    public function test_get_todays_appointments()
    {
        Appointment::factory()->count(2)->create(['date_time' => now()]);
        Appointment::factory()->count(1)->create(['date_time' => now()->addDays(1)]);

        $result = $this->service->getTodayAppointments();

        $this->assertCount(2, $result);
    }
}
