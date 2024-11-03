<?php

namespace App\Repositories\Role;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Role list with all the privileges
     *
     * @param User $user
     * @return array
     */
    public function rolesListWithPrivileges(User $user): array
    {
        if ($user->roles[0]->slug == 'admin') {
            // Admins can see all roles
            $roles = $this->model->get();
        } else {
            // Regular users can see only their roles
            $roles = $this->model->whereNot('slug', 'admin')->get();
        }
        $roles->load(['privileges']);
        return $roles->toArray();

    }

    /**
     * Generate Slug
     *
     * @param  string $name
     * @return string
     */
    public function generateSlug(string $name): string
    {
        return Str::slug($name);
    }

    /**
     * Find roles by their IDs.
     *
     * @param  array  $roleIds
     * @return Collection
     */
    public function findRolesByIds(array $roleIds): Collection
    {
        return $this->model->whereIn('id', $roleIds)->get();
    }

    /**
     * @param Role $role
     * @param Privilege $privilege
     * @return void
     */
    public function assignPrivilege(Role $role, Privilege $privilege): void
    {
        $role->privileges()->attach($privilege);
    }

    /**
     * @param Role $role
     * @param Privilege $privilege
     * @return void
     */
    public function revokePrivilege(Role $role, Privilege $privilege): void
    {
        $role->privileges()->detach($privilege);
    }

}
