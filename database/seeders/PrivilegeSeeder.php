<?php

namespace Database\Seeders;

use App\Enums\PrivilegesEnum;
use App\Models\Privilege;
use App\Models\User;
use App\Repositories\Privilege\PrivilegeRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Seeder;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRepository      = new UserRepository(new User());
        $privilegeRepository = new PrivilegeRepository(new Privilege());

        $privileges = PrivilegesEnum::cases();

        foreach ($privileges as $privilege) {
            try {
                $privilegeSlug = $privilegeRepository->findFirstBy('slug', $privilege->name);
                if ($privilegeSlug !== null) {
                    echo "Privilege with slug '{$privilege->name}' already exists. Skipping...\n";
                } else {
                    $privilegeRepository->create([
                        'slug'       => $privilege->name,
                        'name'       => $privilege->value,
                        'created_by' => $userRepository->findFirstBy('email', 'sysadmin@mail.com')->id,
                    ]);
                }

            } catch (\Exception $exception) {
                echo "Failed to seed {$privilege->name}. {$exception->getMessage()} \n";
            }
        }
    }
}
