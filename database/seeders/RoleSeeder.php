<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRepository = new UserRepository(new User());
        try {
            Role::factory()->create([
                'name' => 'Admin',
                'slug' => 'admin',
                
            ]);
            Role::factory()->create([
                'name' => 'User',
                'slug' => 'user',
                
            ]);
        } catch (\Exception $exception) {
            echo "Failed to seed system user. {$exception->getMessage()}";
        }
    }
}
