<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Complaint\IComplaintRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends BaseController
{
    /**
     * __construct
     *
     * @param  IComplaintRepository $complaintRepository
     * @return void
     */
    public function __construct(
        private readonly IComplaintRepository $complaintRepository
    ) {
    }

    /**
     * complaints By Status report
     *
     * @return JsonResponse
     */
    public function complaintsByStatusReport(): JsonResponse
    {
        try {

            $statusReport = $this->complaintRepository->getComplaintsByStatus();
            return $this->success($statusReport, "Complaints by status report retrieved successfully");
        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }

    }

    public function complaintsByPriority()
    {
        try {

            $priorityReport = $this->complaintRepository->getComplaintsByPriority();
            return $this->success($priorityReport, "Complaints by priority report retrieved successfully");
        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }

    }

    public function averageResolutionTime()
    {
        try {

            $averageResolutionTime = $this->complaintRepository->getAverageResolutionTime();
            return $this->success($averageResolutionTime, "Complaints average resolution time report retrieved successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    public function complaintsTrend(Request $request)
    {
        $startDate = $request->query('start_date'); // YYYY-MM-DD
        $endDate   = $request->query('end_date'); // YYYY-MM-DD
        try {

            $complaintsTrend = $this->complaintRepository->getcomplaintsTrend($startDate, $endDate);
            return $this->success($complaintsTrend, " Complaints trend over time report retrieved successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }

    }

}
