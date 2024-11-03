<?php

namespace App\Repositories\Privilege;

use App\Models\Privilege;
use App\Repositories\BaseRepository;

class PrivilegeRepository extends BaseRepository implements IPrivilegeRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Privilege $model)
    {
        $this->model = $model;
    }

    /**
     * List distinct privileges by hte user id
     *
     * @param  integer $userId
     * @return array
     */
    public function listDistinctPrivilegesByUser(int $userId): array
    {
        return  Privilege::whereHas('roles.users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->distinct()->pluck('slug')->toArray();
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
