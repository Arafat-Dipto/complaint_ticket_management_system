<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Requests\ComplaintCreateRequst;
use App\Http\Services\ComplaintService;
use App\Models\Complaint;
use App\Repositories\Complaint\IComplaintRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends BaseController
{
    use PaginationHelper;

    public function __construct(private readonly IComplaintRepository $complaintRepository, private readonly ComplaintService $complaintService)
    {

    }

    /**
     * List all complaints for the authenticated user
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        try {

            $result = $this->complaintRepository->getAllComplaintsList($user, $this->paginationOptionsFromRequest());
            return $this->successWithPagination($result, "Complaints list retrieved successfully");
        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * Store a new complaint
     *
     * @return JsonResponse
     */
    public function store(ComplaintCreateRequst $request): JsonResponse
    {
        try {
            $result = $this->complaintService->createComplaint($request->all());
            return $this->success($result, "Complaint created successfully");
        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * View a specific complaint
     *
     * @param  int $complaintId
     * @return JsonResponse
     */
    public function show($complaintId): JsonResponse
    {
        $complaint = $this->complaintRepository->getComplaintDetails($complaintId);
        if (!$complaint) {
            throw new \Exception("Complaint not found with ID: " . $complaintId);
        }

        $result = $complaint->load(['category', 'statusHistory', 'comments.admin']);

        return $this->success($result->toArray(), "Complaint details retrieved successfully");

    }

    /**
     * Admin updates the status of a complaint
     *
     * @param  int $complaintId
     * @return JsonResponse
     */
    public function updateStatus(Request $request, $complaintId): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
        ]);

        try {
            $result = $this->complaintService->updateComplaintStatus($request->json()->all(), $complaintId);
            return $this->success($result, "Complaint status updated successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * Admin adds a comment to a complaint
     *
     * @param  int $complaintId
     * @return JsonResponse
     */
    public function addComment(Request $request, $complaintId): JsonResponse
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        try {
            $result = $this->complaintService->createComment($request->json()->all(), $complaintId);
            return $this->success($result, "Comment added successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }
}
