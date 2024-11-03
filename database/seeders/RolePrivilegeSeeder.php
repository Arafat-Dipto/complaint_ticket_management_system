<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Privilege\PrivilegeRepository;
use App\Repositories\Role\RoleRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Repositories\RolePrivilege\RolePrivilegeRepository;

class RolePrivilegeSeeder extends Seeder
{

    public function __construct(
        private RolePrivilegeRepository $rolePrivilegeRepository,
        private privilegeRepository $privilegeRepository,
        private RoleRepository $roleRepository
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            DB::beginTransaction();
            $systemRole = $this->roleRepository->findFirstBy('slug', 'admin');
            $allprivileges = $this->privilegeRepository->allPrivileges();

            foreach ($allprivileges as $privilegeData) {
                $this->rolePrivilegeRepository->create([
                    'role_id' => $systemRole->id,
                    'privilege_id' => $privilegeData['id']
                ]);
            }

            DB::commit();
            $this->command->info('Role privileges seeded successfully.');
        } catch (\Exception $exception) {
            Log::error('Failed to seed privileges: ' . $exception->getMessage());
            DB::rollBack();
            $this->command->error('Failed to seed Role privileges. Check the log for details.');
        }

    }
}
