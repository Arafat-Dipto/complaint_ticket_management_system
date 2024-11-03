<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\IBaseRepository;

interface IUserRepository extends IBaseRepository
{

    /**
     * @param  User $user
     * @return array
     */
    public function allUsersWithRolesAndPrivileges(User $user): ?array;

}
