<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::factory()->create([
                'name'  => 'System Admin',
                'email' => 'sysadmin@mail.com',
            ]);
        } catch (\Exception $exception) {
            echo "Failed to seed system user. {$exception->getMessage()}";
        }
    }
}
