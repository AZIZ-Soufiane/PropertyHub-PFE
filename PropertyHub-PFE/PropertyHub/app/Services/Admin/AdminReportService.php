<?php

namespace App\Services\Admin;

use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminReportService
{
    /**
     * Get all reports with pagination.
     * 
     * @param int $perPage
     * @return mixed
     */
    public function getAllReports(int $perPage = 15)
    {
        return Report::with('admin')->paginate($perPage);
    }

    /**
     * Get reports by admin.
     * 
     * @param int $adminId
     * @param int $perPage
     * @return mixed
     */
    public function getReportsByAdmin(int $adminId, int $perPage = 15)
    {
        User::findOrFail($adminId); // Verify admin exists

        return Report::where('admin_id', $adminId)
            ->with('admin')
            ->paginate($perPage);
    }

    /**
     * Create a new report.
     * 
     * @param int $adminId
     * @param string $dataSummary
     * @return Report
     */
    public function createReport(int $adminId, string $dataSummary): Report
    {
        return DB::transaction(function () use ($adminId, $dataSummary) {
            $admin = User::findOrFail($adminId);

            // Verify user is an admin
            if ($admin->role !== 'admin') {
                throw new \Exception("Only admins can create reports.");
            }

            return Report::create([
                'admin_id' => $adminId,
                'data_summary' => $dataSummary,
            ]);
        });
    }

    /**
     * Update a report.
     * 
     * @param int $reportId
     * @param string $dataSummary
     * @return Report
     */
    public function updateReport(int $reportId, string $dataSummary): Report
    {
        $report = Report::findOrFail($reportId);
        $report->update(['data_summary' => $dataSummary]);
        return $report;
    }

    /**
     * Delete a report.
     * 
     * @param int $reportId
     * @return void
     */
    public function deleteReport(int $reportId): void
    {
        $report = Report::findOrFail($reportId);
        $report->delete();
    }

    /**
     * Get report details.
     * 
     * @param int $reportId
     * @return Report
     */
    public function getReportDetails(int $reportId): Report
    {
        return Report::with('admin')->findOrFail($reportId);
    }

    /**
     * Get recent reports.
     * 
     * @param int $limit
     * @return mixed
     */
    public function getRecentReports(int $limit = 10)
    {
        return Report::with('admin')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get report count.
     * 
     * @return int
     */
    public function getReportCount(): int
    {
        return Report::count();
    }

    /**
     * Search reports by data summary.
     * 
     * @param string $keyword
     * @param int $perPage
     * @return mixed
     */
    public function searchReports(string $keyword, int $perPage = 15)
    {
        return Report::where('data_summary', 'like', '%' . $keyword . '%')
            ->with('admin')
            ->paginate($perPage);
    }
}
