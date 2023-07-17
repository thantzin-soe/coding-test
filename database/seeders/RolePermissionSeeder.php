<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'list-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-tasks']);
        Permission::create(['name' => 'edit-tasks']);
        Permission::create(['name' => 'delete-tasks']);

        $adminRole = Role::create(['name' => 'Admin']);

        $managerRole = Role::create(['name' => 'Manager']);

        $adminRole->givePermissionTo([
            'list-users',
            'create-users',
            'edit-users',
            'delete-users',
            'create-tasks',
            'edit-tasks',
            'delete-tasks',
        ]);

        $managerRole->givePermissionTo([
            'create-tasks',
            'edit-tasks',
            'delete-tasks',
        ]);

        $admin = User::where('email', 'admin@gmail.com')->firstOrFail();
        $admin->assignRole($adminRole);

        $manager = User::where('email', 'manager@gmail.com')->firstOrFail();
        $manager->assignRole($managerRole);
    }
}
