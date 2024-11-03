<?php
namespace App\Http\Services;

use App\Repositories\Privilege\PrivilegeRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
        private PrivilegeRepository $privilegeRepository

    ) {

    }

    /**
     * Create user and attach role with user
     *
     * @param  array $data
     * @return array|null
     */
    public function createUserAndAttachRole(array $data): ?array
    {
        try {
            $roleIds = data_get($data, 'roles');

            $roles = $this->roleRepository->findRolesByIds($roleIds);

            if (count($roles) !== count($roleIds)) {
                throw new \Exception('One or more roles were not found.');
            }

            DB::beginTransaction();
            $user = $this->userRepository->create([
                'name'      => data_get($data, 'name'),
                'email'     => data_get($data, 'email'),
                'password'  => Hash::make(data_get($data, 'password')),
                'is_active' => data_get($data, 'is_active'),
            ]);

            $user->roles()->attach($roles);
            DB::commit();

            $createdUser = $this->userRepository->find($user->id);
            $createdUser->load(['roles']);

            return $createdUser->toArray();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create user and attach role with user
     *
     * @param  array $data
     * @param  int $userId
     * @return array|null
     */
    public function updateUserAndAttachRole(array $data, int $userId): ?array
    {
        try {
            $roleIds = data_get($data, 'roles');

            // Check if the user exists
            $userIsExist = $this->userRepository->find($userId);
            if (!$userIsExist) {
                throw new \Exception("User with ID {$userId} not found.");
            }

            // Find roles by their IDs
            $roles = $this->roleRepository->findRolesByIds($roleIds);

            // Check if all the roles exist
            if (count($roles) !== count($roleIds)) {
                throw new \Exception('One or more roles were not found.');
            }

            DB::beginTransaction();

            // Prepare user data for update
            $userData = [
                'name'      => data_get($data, 'name'),
                'email'     => data_get($data, 'email') ?? $userIsExist->email,
                'is_active' => data_get($data, 'is_active'),
            ];

            // Hash password if provided
            if ($password = data_get($data, 'password')) {
                $userData['password'] = Hash::make($password);
            }

            // Update the user
            $updatedUser = $this->userRepository->update($userId, $userData);

            // Sync roles with user
            $roleIdsToSync = $roles->pluck('id')->toArray();
            $updatedUser->roles()->sync($roleIdsToSync);

            DB::commit();

            // Reload user with roles
            $user = $this->userRepository->find($updatedUser->id);
            $user->load(['roles']);
            return $user->toArray();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Manage assign privileges and revoke privileges to the role.
     *
     * @param  array $data
     * @param  int $roleId
     * @return array
     */
    public function managePrivileges(array $data, int $roleId): array
    {
        try {
            $role         = $this->roleRepository->find($roleId);
            $privilegeIds = data_get($data, 'privilege_ids') ?? [];

            $existingPrivilegeIds = $role->privileges->pluck('id')->toArray();

            $newPrivilegeIds      = array_diff($privilegeIds, $existingPrivilegeIds);
            $toRemovePrivilegeIds = array_diff($existingPrivilegeIds, $privilegeIds);

            DB::beginTransaction();

            foreach ($newPrivilegeIds as $privilegeId) {
                $privilege = $this->privilegeRepository->find($privilegeId);
                $this->roleRepository->assignPrivilege($role, $privilege);
            }

            foreach ($toRemovePrivilegeIds as $privilegeId) {
                $privilege = $this->privilegeRepository->find($privilegeId);
                $this->roleRepository->revokePrivilege($role, $privilege);
            }

            DB::commit();

            $user = $this->roleRepository->find($roleId);
            $user->load(['privileges']);
            return $user->toArray();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
