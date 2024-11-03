<?php

namespace Database\Seeders;

use App\Repositories\Role\RoleRepository;
use App\Repositories\UserRole\UserRoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRoleSeeder extends Seeder
{
    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
        private UserRoleRepository $userRoleRepository
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            DB::beginTransaction();

            $sysadmin   = $this->userRepository->findFirstBy('email', 'sysadmin@mail.com');
            $systemRole = $this->roleRepository->findFirstBy('slug', 'admin');

            $this->userRoleRepository->create([
                'user_id' => $sysadmin->id,
                'role_id' => $systemRole->id,
            ]);

            DB::commit();
            $this->command->info('User role seeded successfully.');
        } catch (\Exception $exception) {
            Log::error('Failed to seed user role: ' . $exception->getMessage());
            DB::rollBack();
            $this->command->error('Failed to seed user role. Check the log for details.');
        }
    }
}
