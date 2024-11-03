<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserCreateRequst;
use App\Http\Requests\UserUpdateRequst;
use App\Http\Services\UserService;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * __construct
     *
     * @param  IUserRepository $userRepository
     * @return void
     */
    public function __construct(
        private readonly IUserRepository $userRepository,
        private UserService $userService
    ) {
    }

    /**
     * Get user list
     *
     * @return JsonResponse
     */
    public function getUserList(): JsonResponse
    {
        $user   = Auth::user();
        $result = $this->userRepository->allUsersWithRolesAndPrivileges($user);

        return $this->success($result, "User list retrieved successfully");
    }

    /**
     * User create with role and company
     *
     * @param  UserCreateRequst $request
     * @return JsonResponse
     */
    public function userCreate(UserCreateRequst $request): JsonResponse
    {
        try {
            $result = $this->userService->createUserAndAttachRole($request->json()->all());
            return $this->success($result, "User created successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * User update with role and company
     *
     * @param  UserUpdateRequst $request
     * @param  int  $userId
     * @return JsonResponse
     */
    public function userUpdate(UserUpdateRequst $request, int $userId): JsonResponse
    {
        try {
            $result = $this->userService->updateUserAndAttachRole($request->json()->all(), $userId);
            return $this->success($result, "User updated successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * user delete
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function deleteUser($id): JsonResponse
    {
        try {
            $user = $this->userRepository->find($id);
            if (!$user) {
                throw new \Exception("User not found with ID: " . $id);
            }

            $this->userRepository->delete($id);

            return $this->success([], "User deleted successfully");

        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }
}
