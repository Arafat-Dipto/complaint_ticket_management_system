<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * User list with roles and privileges
     *
     * @param User $user
     * @return null|array
     */
    public function allUsersWithRolesAndPrivileges(User $user): ?array
    {
        if ($user->roles[0]->slug == 'admin') {
            // Admins can see all users
            $users = $this->model->with(['roles.privileges'])->get()->toArray();

        } else {
            // Regular users can see only their users
            $users = $this->model->whereHas('roles', function ($query) {
                $query->where('slug', '!=', 'admin');
            })->with(['roles' => function ($query) {
                $query->where('slug', '!=', 'admin')->with('privileges');
            }])->get()->toArray();
        }
        return $users;
    }

}
