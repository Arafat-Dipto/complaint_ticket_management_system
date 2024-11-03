<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PrivilegeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RolePrivilegeSeeder::class);
        $this->call(UserRoleSeeder::class);
    }
}
