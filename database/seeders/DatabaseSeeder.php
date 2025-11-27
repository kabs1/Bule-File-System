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
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // Create a super user
        $superUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password'), // You should change this in production
                'role_id' => $superAdminRole->id, // Assign the role_id
                'status' => 1,
            ]
        );

        // Assign the super admin role to the super user
        $superUser->assignRole($superAdminRole);

        // Core Role permissions
        Permission::firstOrCreate(['name' => 'view role']);
        Permission::firstOrCreate(['name' => 'create role']);
        Permission::firstOrCreate(['name' => 'update role']);
        Permission::firstOrCreate(['name' => 'delete role']);

        // Core Permission permissions
        Permission::firstOrCreate(['name' => 'view permission']);
        Permission::firstOrCreate(['name' => 'create permission']);
        Permission::firstOrCreate(['name' => 'update permission']);
        Permission::firstOrCreate(['name' => 'delete permission']);

        // Backup permissions (match Blade checks)
        Permission::firstOrCreate(['name' => 'create backup']);
        Permission::firstOrCreate(['name' => 'download backup']);
        Permission::firstOrCreate(['name' => 'delete backup']);

        // Activity Log permissions (if needed)
        Permission::firstOrCreate(['name' => 'view activity log']);
        Permission::firstOrCreate(['name' => 'delete activity log']);

        // Assign all permissions to super admin
        $superAdminRole->syncPermissions(Permission::all());

        // Optionally create a regular user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'username' => 'testuser',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id, // Assign a role_id, assuming 'Super Admin' for now
                'status' => 1,
            ]
        );
    }
}
