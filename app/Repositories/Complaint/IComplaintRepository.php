<?php

namespace App\Repositories\Complaint;

use App\Models\Complaint;
use App\Models\User;
use App\Repositories\IBaseRepository;

interface IComplaintRepository extends IBaseRepository
{

    /**
     * @param User $user
     * @param array $paginationOptions
     * @return null|array
     */
    public function getAllComplaintsList(User $user, array $paginationOptions = []): ?array;

    /**
     * @param  int $complaintId
     * @return null|Complaint
     */
    public function getComplaintDetails(int $complaintId): ?Complaint;

    /**
     * @return null|array
     */
    public function getComplaintsByStatus(): ?array;

    /**
     * @return null|array
     */
    public function getComplaintsByPriority(): ?array;

    /**
     * @return null|array
     */
    public function getAverageResolutionTime(): ?array;

    /**
     * @param  string $startDate
     * @param  string $endDate
     * @return null|array
     */
    public function getcomplaintsTrend(string $startDate, string $endDate): ?array;

}
