<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AssignPrivilegeRequest;
use App\Http\Requests\RoleCreateOrUpdateRequest;
use App\Http\Services\UserService;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\RoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoleController extends BaseController
{
    /**
     * __construct
     *
     * @param  IRoleRepository $roleRepository
     * @return void
     */
    public function __construct(private readonly IRoleRepository $roleRepository, private UserService $userService)
    {
    }

    /**
     * Get all role list with privileges
     *
     * @return JsonResponse
     */
    public function getRoleList(): JsonResponse
    {
        $user   = Auth::user();
        $result = $this->roleRepository->rolesListWithPrivileges($user);

        return $this->success($result, "Roles list retrieved successfully");
    }

    /**
     * Store role or update
     *
     * @param  RoleCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function roleStoreOrUpdate(RoleCreateOrUpdateRequest $request): JsonResponse
    {
        try {
            $slug = $this->roleRepository->generateSlug($request->name);

            if ($request->filled('id')) {

                $result = $this->roleRepository->update($request->id, [
                    'name' => $request->name,
                    'slug' => $slug,
                ]);

                return $this->success($result->toArray(), "Role updated successfully");

            } else {
                $result = $this->roleRepository->create([
                    'name' => $request->name,
                    'slug' => $slug,
                ]);

                return $this->success($result->toArray(), "Role created successfully");
            }

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), [
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

    /**
     * Show role details
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function roleDetails($id): JsonResponse
    {
        $result = $this->roleRepository->findFirstBy('id', $id);

        return $this->success($result->toArray(), "Role details retrieved successfully");

    }

    /**
     *
     * Assign and revoke privileges by role
     *
     * @param  AssignPrivilegeRequest $request
     * @param  integer $roleId
     * @return JsonResponse
     */
    public function assignAndRevokePrivilegesByRole(AssignPrivilegeRequest $request, $roleId): JsonResponse
    {
        try {
            $result = $this->userService->managePrivileges($request->json()->all(), $roleId);
            return $this->success($result, "Privileges assigned successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * role delete
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function deleteRole($id): JsonResponse
    {
        try {
            $role = $this->roleRepository->find($id);
            if (!$role) {
                throw new \Exception("Role not found with ID: " . $id);
            }

            $hasAssignedUser = $role->users()
                ->exists();

            if ($hasAssignedUser) {
                throw new \Exception("This role has assigned user(s). Cannot delete Role : " . $role->name);
            } else {
                $this->roleRepository->delete($id);
            }
            return $this->success([], "Role deleted successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

}
