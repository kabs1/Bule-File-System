<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a super user
        $superUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password'), // You should change this in production
                'status' => 1,
            ]
        );

        // Assign the super admin role to the super user
        $superUser->assignRole('super-admin');

        // Optionally create a regular user
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'username' => 'testuser',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        );
        $testUser->assignRole('super-admin'); // Assign a role, assuming 'super-admin' for now
    }
}
