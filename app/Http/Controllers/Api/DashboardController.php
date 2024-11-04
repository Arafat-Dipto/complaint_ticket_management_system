<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    /**
     * Get dashboard statistics
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {

            $user = Auth::user();
            $totalUsers = User::count();
            if ($user->roles[0]->slug == 'admin') {
                $totalComplaints = Complaint::count();
                $totalComments = Comment::count();
    
            } else {
                $totalComplaints = $user->complaints()->count();
                $totalComments = Comment::whereIn('complaint_id', $user->complaints()->pluck('id'))->count();
            }
            

            return $this->success([
                'total_users' => $totalUsers,
                'total_complaints' => $totalComplaints,
                'total_comments' => $totalComments,
            ], 'Dashboard statistics retrieved successfully.');
        } catch (\Exception $e) {
            return $this->error('Error retrieving dashboard data.', [$e->getMessage()]);
        }
    }
}
