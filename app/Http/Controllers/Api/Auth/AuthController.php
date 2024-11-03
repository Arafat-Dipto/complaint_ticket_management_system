<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\AuthenticationRequest;
use App\Models\Role;
use App\Repositories\Privilege\IPrivilegeRepository;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\UserRole\IUserRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __construct(private IPrivilegeRepository $privilegeRepository, private IUserRepository $userRepository, private IUserRoleRepository $userRoleRepository, private IRoleRepository $roleRepository)
    {}

    /**
     * Register a new user.
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        try {

            // Create a new user
            $user = $this->userRepository->create([
                'name'              => $request->name,
                'email'             => $request->email,
                'email_verified_at' => now(),
                'password'          => Hash::make($request->password),
                'is_active'         => true,
            ]);
    
            $this->userRoleRepository->create([
                'user_id' => $user->id,
                'role_id' => $this->roleRepository->findFirstBy('slug', 'user')->id,
            ]);
    
            return $this->success([
                "id"         => $user->id,
                "name"       => $user->name,
                "email"      => $user->email,
            ], 'User Registered Successfully');
        } catch (\Exception $e) {
            return $this->error('Error', [$e->getMessage()]);
        }
    }

    /**
     * Handle user login.
     *
     * @param  AuthenticationRequest  $request
     * @return JsonResponse
     */
    public function login(AuthenticationRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->is_active) {
                return $this->error('User account is not active.', [
                    'code' => Response::HTTP_UNAUTHORIZED,
                ], Response::HTTP_UNAUTHORIZED);
            }
            $userWithRoleAndPrivilege = $this->privilegeRepository->listDistinctPrivilegesByUser($user->id);

            return $this->success([
                "id"         => $user->id,
                "name"       => $user->name,
                "email"      => $user->email,
                'privileges' => $userWithRoleAndPrivilege,
                'token'      => $user->createToken(name: 'auth-token', abilities: $userWithRoleAndPrivilege)->plainTextToken,
            ], 'User Logged In Successfully');

        }

        return $this->error('Invalid credentials.', [
            'code' => Response::HTTP_UNAUTHORIZED,
        ], Response::HTTP_UNAUTHORIZED);
    }
}
