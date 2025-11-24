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
        // Create a super admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // Create a super user
        $superUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // You should change this in production
            ]
        );

        // Assign the super admin role to the super user
        $superUser->assignRole($superAdminRole);

        // Give all permissions to the super admin role
        $allPermissions = Permission::all();
        // Create permissions for Backup
        Permission::firstOrCreate(['name' => 'backup.view']);
        Permission::firstOrCreate(['name' => 'backup.create']);
        Permission::firstOrCreate(['name' => 'backup.delete']);

        // Create permissions for Activity Log
        Permission::firstOrCreate(['name' => 'activity_log.view']);
        Permission::firstOrCreate(['name' => 'activity_log.delete']);

        // Give all permissions to the super admin role
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        // Optionally create a regular user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );
    }
}
