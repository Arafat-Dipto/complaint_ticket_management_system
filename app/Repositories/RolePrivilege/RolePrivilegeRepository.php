<?php
namespace App\Repositories\RolePrivilege;

use App\Models\RolePrivilege;
use App\Repositories\BaseRepository;

class RolePrivilegeRepository extends BaseRepository implements IRolePrivilegeRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(RolePrivilege $model)
    {
        $this->model = $model;
    }
}
