<?php

namespace App\Repositories\ComplaintStatusHistory;

use App\Models\ComplaintStatusHistory;
use App\Repositories\BaseRepository;

class ComplaintStatusHistoryRepository extends BaseRepository implements IComplaintStatusHistoryRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(ComplaintStatusHistory $model)
    {
        $this->model = $model;
    }

    /**
     * all the privileges
     *
     * @return null|array
     */
    public function allPrivileges(): ?array
    {
        return $this->model::all()->toArray();
    }

}
