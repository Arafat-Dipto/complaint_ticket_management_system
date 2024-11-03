<?php

namespace Database\Factories;

use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolePrivilege>
 */
class RolePrivilegeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user      = User::factory()->create();
        $role      = Role::factory()->create();
        $privilege = Privilege::factory()->create();
        return [
            'role_id'      => $role->id,
            'privilege_id' => $privilege->id,
            'created_by'   => $user->id,
        ];

    }
}
