<?php
namespace App\Repositories\UserRole;

use App\Models\UserRole;
use App\Repositories\BaseRepository;
use App\Repositories\UserRole\IUserRoleRepository;

class UserRoleRepository extends BaseRepository implements IUserRoleRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(UserRole $model)
    {
        $this->model = $model;
    }
}
