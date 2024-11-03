<?php

namespace App\Repositories\Complaint;

use App\Enums\StatusTypeEnum;
use App\Helpers\PaginationHelper;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ComplaintRepository extends BaseRepository implements IComplaintRepository
{
    use PaginationHelper;

    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Complaint $model)
    {
        $this->model = $model;
    }

    /**
     * all the complaints
     *
     * @param User $user
     * @param array $paginationOptions
     * @return null|array
     */
    public function getAllComplaintsList(User $user, array $paginationOptions = []): ?array
    {
        if ($user->roles[0]->slug == 'admin') {
            // Admins can see all complaints
            $complaints = $this->model->with(['user', 'category', 'statusHistory']);

        } else {
            // Regular users can see only their complaints
            $complaints = $user->complaints()->with('user', 'category', 'statusHistory');
        }

        $perPage = $paginationOptions['perPage'] ?? 5;
        $page    = $paginationOptions['page'] ?? 1;

        return $this->paginateCollection($complaints->get(), $perPage, $page);

    }

    /**
     * @param  int $complaintId
     * @return Complaint|null
     */
    public function getComplaintDetails(int $complaintId): ?Complaint
    {
        return $this->model->where('id', $complaintId)->first();
    }

    /**
     * get Complaints By Status
     *
     * @return null|array
     */
    public function getComplaintsByStatus(): ?array
    {
        return $this->model->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()->toArray();
    }

    /**
     * get Complaints By Priority
     *
     * @return null|array
     */
    public function getComplaintsByPriority(): ?array
    {
        return $this->model->select('priority', DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->get()->toArray();
    }

    /**
     * get Complaints average resolution time
     *
     * @return null|array
     */
    public function getAverageResolutionTime(): ?array
    {
        return $this->model
            ->select('category_id', DB::raw('AVG(DATEDIFF(resolved_at, submitted_at)) as avg_resolution_time'))
            ->whereNotNull('resolved_at') // Ensure only resolved complaints are included
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                // Optionally format the result as needed
                return [
                    'category' => $this->getCategoryNameById($item->category_id), // Assuming a function to get category name
                    'average_resolution_time' => round($item->avg_resolution_time, 1) . ' days',
                ];
            })->toArray();
    }

    // Helper function to get category name by ID (if needed)
    protected function getCategoryNameById($categoryId)
    {
        $category = Category::find($categoryId); // Assuming you have a Category model
        return $category ? $category->name : 'Unknown Category';
    }
    /**
     * get Complaints tren over time
     *
     * @return null|array
     */
    public function getComplaintsTrend(string $startDate, string $endDate): ?array
    {
        $startDate = Carbon::parse($startDate)->format('Y-m-d');
        $endDate   = Carbon::parse($endDate)->format('Y-m-d');

        return $this->model->select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
            DB::raw('count(*) as total_submitted'),
            DB::raw("sum(case when status = '" . StatusTypeEnum::Resolved->value . "' then 1 else 0 end) as total_resolved"),
            DB::raw("sum(case when status = '" . StatusTypeEnum::Closed->value . "' then 1 else 0 end) as total_closed")
        )
            ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), [$startDate, $endDate])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->get()
            ->toArray();
    }

}
