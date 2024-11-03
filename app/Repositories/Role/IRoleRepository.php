<?php

namespace App\Repositories\Role;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use App\Repositories\IBaseRepository;

interface IRoleRepository extends IBaseRepository
{
    /**
     * @param  string $name
     * @return string
     */
    public function generateSlug(string $name): string;

    /**
     * @param User $user
     * @return array
     */
    public function rolesListWithPrivileges(User $user): array;

    /**
     * @param Role $role
     * @param Privilege $privilege
     * @return void
     */
    function assignPrivilege(Role $role, Privilege $privilege): void;

    /**
     * @param Role $role
     * @param Privilege $privilege
     * @return void
     */
    function revokePrivilege(Role $role, Privilege $privilege): void;
}
