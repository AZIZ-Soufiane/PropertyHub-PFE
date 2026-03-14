<?php

namespace Tests\Unit\Services\Admin;

use Tests\TestCase;
use App\Models\Report;
use App\Models\User;
use App\Services\Admin\AdminReportService;

class AdminReportServiceTest extends TestCase
{
    protected AdminReportService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminReportService();
    }

    public function test_get_all_reports()
    {
        Report::factory()->count(5)->create();

        $result = $this->service->getAllReports(15);

        $this->assertCount(5, $result->items());
    }

    public function test_get_reports_by_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Report::factory()->count(3)->create(['admin_id' => $admin->id]);

        $result = $this->service->getReportsByAdmin($admin->id);

        $this->assertCount(3, $result->items());
    }

    public function test_create_report()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $report = $this->service->createReport($admin->id, 'Monthly summary data');

        $this->assertEquals($admin->id, $report->admin_id);
        $this->assertEquals('Monthly summary data', $report->data_summary);
    }

    public function test_create_report_throws_exception_for_non_admin()
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Only admins can create reports");

        $this->service->createReport($agent->id, 'Summary');
    }

    public function test_update_report()
    {
        $report = Report::factory()->create();

        $updated = $this->service->updateReport($report->id, 'Updated summary');

        $this->assertEquals('Updated summary', $updated->data_summary);
    }

    public function test_delete_report()
    {
        $report = Report::factory()->create();

        $this->service->deleteReport($report->id);

        $this->assertNull(Report::find($report->id));
    }

    public function test_get_report_details()
    {
        $report = Report::factory()->create();

        $result = $this->service->getReportDetails($report->id);

        $this->assertEquals($report->id, $result->id);
    }

    public function test_get_recent_reports()
    {
        Report::factory()->count(5)->create();

        $result = $this->service->getRecentReports(3);

        $this->assertCount(3, $result);
    }

    public function test_get_report_count()
    {
        Report::factory()->count(5)->create();

        $count = $this->service->getReportCount();

        $this->assertEquals(5, $count);
    }

    public function test_search_reports()
    {
        Report::factory()->create(['data_summary' => 'Monthly summary data']);
        Report::factory()->create(['data_summary' => 'Quarterly report']);

        $result = $this->service->searchReports('Monthly');

        $this->assertCount(1, $result->items());
    }
}
