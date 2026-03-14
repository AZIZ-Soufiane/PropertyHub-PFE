<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\Calendar;
use App\Models\User;
use App\Models\Appointment;
use App\Services\Admin\AdminCalendarService;

class AdminCalendarServiceTest extends TestCase
{
    protected AdminCalendarService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminCalendarService();
    }

    public function test_get_all_calendars()
    {
        Calendar::factory()->count(5)->create();

        $result = $this->service->getAllCalendars(15);

        $this->assertCount(5, $result->items());
    }

    public function test_get_agent_calendar()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        Calendar::factory()->create(['agent_id' => $agent->id]);

        $calendar = $this->service->getAgentCalendar($agent->id);

        $this->assertEquals($agent->id, $calendar->agent_id);
    }

    public function test_get_agent_calendar_throws_exception_for_no_calendar()
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Agent does not have a calendar");

        $this->service->getAgentCalendar($agent->id);
    }

    public function test_create_calendar_for_agent()
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $calendar = $this->service->createCalendarForAgent($agent->id);

        $this->assertEquals($agent->id, $calendar->agent_id);
    }

    public function test_create_calendar_throws_exception_for_existing_calendar()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        Calendar::factory()->create(['agent_id' => $agent->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Agent already has a calendar");

        $this->service->createCalendarForAgent($agent->id);
    }

    public function test_create_calendar_throws_exception_for_non_agent()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Can only create calendar for agents");

        $this->service->createCalendarForAgent($buyer->id);
    }

    public function test_delete_calendar()
    {
        $calendar = Calendar::factory()->create();

        $this->service->deleteCalendar($calendar->id);

        $this->assertNull(Calendar::find($calendar->id));
    }

    public function test_delete_calendar_throws_exception_for_existing_appointments()
    {
        $calendar = Calendar::factory()->create();
        Appointment::factory()->create(['calendar_id' => $calendar->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot delete calendar with existing appointments");

        $this->service->deleteCalendar($calendar->id);
    }

    public function test_get_calendar_with_appointments()
    {
        $calendar = Calendar::factory()->create();
        Appointment::factory()->count(3)->create(['calendar_id' => $calendar->id]);

        $result = $this->service->getCalendarWithAppointments($calendar->id);

        $this->assertEquals($calendar->id, $result->id);
    }

    public function test_get_calendar_appointments_by_date_range()
    {
        $calendar = Calendar::factory()->create();
        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(7)->format('Y-m-d');

        Appointment::factory()->count(3)->create([
            'calendar_id' => $calendar->id,
            'date_time' => now()->addDays(2),
        ]);

        $result = $this->service->getCalendarAppointmentsByDateRange($calendar->id, $startDate, $endDate);

        $this->assertCount(3, $result);
    }

    public function test_get_calendar_details()
    {
        $calendar = Calendar::factory()->create();

        $result = $this->service->getCalendarDetails($calendar->id);

        $this->assertEquals($calendar->id, $result->id);
    }

    public function test_get_calendar_statistics()
    {
        Calendar::factory()->count(5)->create();

        $stats = $this->service->getCalendarStatistics();

        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total_calendars', $stats);
        $this->assertEquals(5, $stats['total_calendars']);
    }

    public function test_agent_has_calendar()
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $this->assertFalse($this->service->agentHasCalendar($agent->id));

        Calendar::factory()->create(['agent_id' => $agent->id]);

        $this->assertTrue($this->service->agentHasCalendar($agent->id));
    }
}
