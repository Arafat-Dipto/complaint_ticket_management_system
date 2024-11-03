<?php

namespace App\Repositories\Privilege;

use App\Repositories\IBaseRepository;

interface IPrivilegeRepository extends IBaseRepository
{

    /**
     * List disctint privileges by user id
     *
     * @param  integer $userId
     * @return array
     */
    public function listDistinctPrivilegesByUser(int $userId): array;

    /**
     * @return null|array
     */
    public function allPrivileges(): ?array;

}
