<?php

namespace App\Repositories\ComplaintStatusHistory;

use App\Repositories\IBaseRepository;

interface IComplaintStatusHistoryRepository extends IBaseRepository
{

    /**
     * @return null|array
     */
    public function allPrivileges(): ?array;

}
